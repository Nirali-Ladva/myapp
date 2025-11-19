<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>@yield('title', 'Admin')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        @auth
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.profile.edit') }}">Profile</a></li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="btn btn-link nav-link">Logout</button>
            </form>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  @yield('content')
</div>

<!-- File preview modal -->
<div class="modal fade" id="filePreviewModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-body p-0" id="filePreviewBody" style="min-height:60vh"></div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function previewFile(url){
  const body = document.getElementById('filePreviewBody');
  body.innerHTML = '';
  if(!url) return;
  if (url.match(/\.pdf$/i)) {
    body.innerHTML = '<iframe src="'+url+'" style="width:100%;height:80vh;border:0"></iframe>';
  } else {
    body.innerHTML = '<img src="'+url+'" style="width:100%;height:auto"/>';
  }
  const modalEl = document.getElementById('filePreviewModal');
  const modal = new bootstrap.Modal(modalEl);
  modal.show();
}
</script>

@stack('scripts')
</body>
</html>
