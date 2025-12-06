<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Manwah — Taiwanese Hotpot</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <!-- Bootstrap for quick layout (optional) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;}
    .hero{
      min-height:64vh;
      background-image: url('{{ asset('storage/images/landing_hero.jpg') }}');
      background-size: 80% auto;
      background-position:center;
      background-color: ;
    background-repeat: no-repeat;       /* không lặp nữa */

  padding-left: 10%;
    padding-right: 10%;
      color:#fff;
      display:flex;
      align-items:center;
      position:relative;
    }
    .overlay{position:absolute;inset:0;}
    .hero .container{position:relative;z-index:2}
    .card-menu img{height:120px;object-fit:cover;width:100%;border-radius:6px}
    .gallery img{width:100%;height:160px;object-fit:cover;border-radius:6px}
    footer{background:#0b0b0b;color:#ddd;padding:30px 0}
    .btn-primary{background:#d43c3c;border:0}

 .gallery-img {
  width: 100%;
  height: 380px;        /* ẢNH RẤT TO */
  object-fit: cover;
  border-radius: 12px;
}


  </style>
</head>
<body>
  <!-- Header -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">
        <img src="https://manwah.com.vn/images/logo/manwah.svg" alt="Manwah Logo" height="40">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navNav" aria-controls="navNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navNav">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item"><a class="nav-link" href="#about">Giới thiệu</a></li>
          <li class="nav-item"><a class="nav-link" href="#menu">Thực đơn</a></li>
          <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Liên hệ</a></li>
          <li class="nav-item ms-3"><a class="btn btn-outline-primary" href="{{ route('login') }}">Đăng nhập</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <header class="hero">
    <div class="overlay"></div>
    <!-- <div class="container text-center text-white">
      <h1 class="display-5 fw-bold">Manwah — Lẩu Đài Loan chính hiệu</h1>
      <p class="lead">Hương vị đậm đà, nguyên liệu tươi ngon — phù hợp cho gia đình & bạn bè</p>
      <div class="d-flex justify-content-center gap-2">
        <a href="#menu" class="btn btn-primary btn-lg">Xem thực đơn</a>
        <a href="#contact" class="btn btn-outline-light btn-lg">Đặt bàn</a>
      </div>
      <p class="mt-3 small">Trang này có thể xem mà không cần đăng nhập — khách hàng dễ tiếp cận thông tin.</p> -->
    </div>
  </header>

  <!-- About -->
  <section id="about" class="py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h3>Về Manwah</h3>
<p>
  Sau hàng trăm năm tồn tại trong cuộc sống người Đài, lẩu Đài Loan không chỉ đơn thuần là sự kết hợp của các nguyên liệu quen thuộc, mà liên tục được cải tiến và hoàn thiện, từ thế hệ này sang thế hệ khác. Thực khách đến Manwah sẽ được tự mình khám phá hành trình ẩm thực đặc sắc với nước lẩu ngọt vị tự nhiên, kết hợp hầm cùng các loại gia vị dậy mùi thơm đặc trưng của Đài Loan. Nét đặc sắc không chỉ đến từ nước lẩu, mà còn đến từ cả những món nhúng kiểu Đài – bạn sẽ tìm thấy nhiều hơn là chỉ thịt bò và các loại rau thơm. Chính sự kết hợp các nguyên liệu, món ăn hài hoà sẽ tạo nên hương vị lẩu Đài Loan tỉ mỉ và tinh tế.
</p>          <ul>
            <li>Đa dạng nước lẩu: Mala, Cà chua, Nấm, Thanh đạm</li>
            <li>Buffet & gọi món — phù hợp theo nhóm</li>
            <li>Ưu đãi đặt bàn trực tuyến</li>
          </ul>
        </div>
        <div class="col-md-6 d-flex gap-2">
    <img src="{{ asset('storage/images/manwah-aboutscaled.jpg') }}"
         class="img-fluid rounded shadow flex-fill" style="max-width: 50%;" alt="">

    <img src="{{ asset('storage/images/manwah_about.jpg') }}"
         class="img-fluid rounded shadow flex-fill" style="max-width: 50%;" alt="">
</div>

      </div>
    </div>
  </section>

  <!-- Menu highlights -->
  <section id="menu" class="py-5 bg-light">
    <div class="container">
      <h3 class="mb-4 font-weight:bolder">Buffet</h3>
      <div class="row g-3">
        <div class="col-md-4">
          <div class="card p-3 card-menu h-100">
            <img src="{{ asset('storage/images/Phong_Van279.jpg') }}" alt="Set lẩu">
            <div class="card-body p-0 mt-2">
              <h5 class="mb-1">  Phong Vân</h5>
              <p class="small mb-0">Set cho 2-3 người — nhiều topping, nước lẩu đặc trưng.</p>
              <p class="mt-2 fw-bold">Từ 259.000 đ</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card p-3 card-menu h-100">
            <img src="{{ asset('storage/images/dai_nguu_tran_379.jpg') }}" alt="Hải sản">
            <div class="card-body p-0 mt-2">
              <h5 class="mb-1"> Đài Ngưu Trân</h5>
              <p class="small mb-0">Hải sản và nhiều loại thịt bò nhập khẩu thượng hạn — phù hợp ăn cùng lẩu nấm.</p>
              <p class="mt-2 fw-bold">399.000/người</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card p-3 card-menu h-100">
            <img src="{{ asset('storage/images/DaiNguuHoa469.jpg') }}" alt="Rau nấm">
            <div class="card-body p-0 mt-2">
              <h5 class="mb-1">Đài Ngưu Hoa </h5>
              <p class="small mb-0">Thịt bò nhâp khẩu, hải sản thượng hang, Và đặc biệt có các loại thịt bò tươi..</p>
              <p class="mt-2 fw-bold">Từ 469.000/người</p>
            </div>
          </div>
        </div>
      </div>

      <div class="text-center mt-4">
        <a href="#contact" class="btn btn-outline-primary">Đặt bàn / Liên hệ</a>
      </div>
    </div>
  </section>

  <!-- Gallery -->
<section id="gallery" class="py-5">
  <div class="container">
    <h3 class="mb-4">Gallery</h3>
    <div class="row g-3 gallery">
      <div class="col-6 col-md-3">
        <img class="gallery-img" src="https://brand-pcms.ggg.systems/media/catalog/product/cache/fccf9bc1c56510f6f2e84ded9c30a375/1/9/19259_combo-phuc-di-tuong.jpg" alt="photo">
      </div>
      <div class="col-6 col-md-3">
        <img class="gallery-img" src="https://brand-pcms.ggg.systems/media/catalog/product/cache/fccf9bc1c56510f6f2e84ded9c30a375/s/e/set_nt-web.png" alt="photo">
      </div>
      <div class="col-6 col-md-3">
        <img class="gallery-img" src="https://brand-pcms.ggg.systems/media/catalog/product/cache/fccf9bc1c56510f6f2e84ded9c30a375/1/9/19258_combo-phuc-di-an.jpg" alt="photo">
      </div>
      <div class="col-6 col-md-3">
        <img class="gallery-img" src="https://brand-pcms.ggg.systems/media/catalog/product/cache/fccf9bc1c56510f6f2e84ded9c30a375/s/o/song-vu-web.png" alt="photo">
      </div>
    </div>
  </div>
</section>


  <!-- Contact / Location -->
  <section id="contact" class="py-5 bg-light">
    <div class="container">
      <h3>Liên hệ & Địa chỉ</h3>
      <div class="row mt-3">
        <div class="col-md-6">
          <p class="mb-1"><strong>Manwah - Chi nhánh Trung tâm</strong></p>
          <p class="small mb-1">Số 1 Example Street, Quận X, Thành phố Y</p>
          <p class="small mb-1">Điện thoại: <a href="tel:+84-912-345-678">(+84) 912 345 678</a></p>
          <p class="small mb-1">Giờ mở cửa: 10:00 — 22:30 (hàng ngày)</p>
          <div class="mt-3">
            <a href="https://maps.google.com" target="_blank" class="btn btn-primary me-2">Chỉ đường</a>
            <a href="mailto:hello@manwah.vn" class="btn btn-outline-secondary">Gửi email</a>
          </div>
        </div>
        <div class="col-md-6">
          <!-- simple booking form (public) -->
          <div class="card p-3">
            <h5>Đặt bàn nhanh</h5>
           <form action="{{ route('reservations.store') }}" method="POST">
    @csrf

    <div class="mb-2">
        <input class="form-control" name="customer_name" placeholder="Họ tên" required>
    </div>

    <div class="mb-2">
        <input class="form-control" name="customer_phone" placeholder="Số điện thoại" required>
    </div>

    <div class="mb-2">
        <input class="form-control" name="reservation_time" type="datetime-local" required>
    </div>

    <div class="mb-2">
        <input class="form-control" name="num_guests" type="number" min="1" required>
    </div>

    <button class="btn btn-primary w-100">Gửi yêu cầu</button>
</form>

            <small class="text-muted d-block mt-2">Lưu ý: khách không cần đăng nhập để gửi yêu cầu đặt bàn.</small>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container text-center">
      <p class="mb-1">© {{ date('Y') }} Manwah — All rights reserved.</p>
      <p class="small mb-0">Xem thêm trên <a href="{{ url('/') }}" class="text-decoration-underline text-white">Trang chính</a></p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
