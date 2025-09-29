# SandboxDemo - Hướng dẫn sử dụng (Tiếng Việt)

Plugin SandboxDemo cung cấp cơ chế “sandbox” để ngăn các thao tác ghi/xóa nguy hiểm khi chạy ở môi trường demo trong hệ sinh thái GP247.

## 1. Thông tin plugin
- **Tên**: SandboxDemo module
- **Nhà phát triển**: GP247
- **Yêu cầu Core**: >=1.2
- **Đường dẫn**: `app/GP247/Plugins/SandboxDemo`

## 2. Cài đặt và kích hoạt
1. Đảm bảo mã nguồn ở đúng đường dẫn: `app/GP247/Plugins/SandboxDemo`.
2. Truy cập trang quản trị Extensions, tìm plugin SandboxDemo và nhấn Install.
3. Sau khi cài, nhấn Enable để kích hoạt.
4. Khi bật, middleware `sandbox-demo` sẽ tự động gắn vào các group: `admin`, `api.extend`, `partner`, `pmo`.

## 3. Middleware Sandbox
- Tên alias: `sandbox-demo` (được khai báo và gắn trong `Provider.php`).
- Điều kiện áp dụng: Khi có đăng nhập hợp lệ (admin/partner/pmo/vendor) và `SANDBOX_DEMO_ENABLED` bật.
- Cho phép: Các request `GET` không thuộc danh sách chặn.
- Chặn: Các request khác sẽ trả về 403 hoặc JSON `{ error: 1, msg: "Access denied for sandbox demo" }`.
- Danh sách path luôn chặn: Các đường dẫn upload xóa/di chuyển/đổi tên/crop... cho các nhóm admin, multivendor, partner (tự động build theo cấu hình prefix).
- Bạn có thể mở rộng:
  - `routeAlwaysAllow()`: cho phép theo tên route (ưu tiên cao nhất).
  - `pathAlwaysAllow()`: cho phép theo path (ưu tiên cao nhất).
  - `routeAlwaysBlock()`: thêm tên route cần chặn.
  - `pathAlwaysBlock()`: thêm path cụ thể cần chặn.
  (Allow-list có ưu tiên cao hơn block-list.)

## 4. Lưu ý khi phát triển
- Sandbox nhằm bảo vệ môi trường demo: hạn chế hành vi ghi/xóa nguy hiểm.
- Khi nhanh chóng vô hiệu hóa Plugin, set giá trị `SANDBOX_DEMO_ENABLED=0` trong biến .env (bạn có thể thêm nếu biến chưa tồn tại).
Lưu ý: SANDBOX_DEMO_ENABLED=0 sẽ vô hiệu hóa Plugin ngay cả khi nó đang được kích hoạt trong admin.

## 5. Hỗ trợ
- Website: `https://GP247.net`
- Email: `support@gp247.net`
