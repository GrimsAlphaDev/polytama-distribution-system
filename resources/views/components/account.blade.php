<div class="body flex-grow-1">
    <div class="container-lg px-4">
        <div class="row g-4 mb-4">
            <!-- Table -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Change Profile Detail</div>
                    <div class="card-body">
                        <form action="{{ route('profile.setting.update', auth()->user()->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" readonly id="nik" nik="name"
                                    value="{{ auth()->user()->nik }}">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ auth()->user()->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ auth()->user()->email }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 mb-4">
            <!-- Table -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Change Password</div>
                    <div class="card-body">
                        <form action="{{ route('profile.setting.changePass', auth()->user()->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Password Confirmation</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // verify password is same as password_confirmation
    const password = document.getElementById('password');
    const password_confirmation = document.getElementById('password_confirmation');

    password_confirmation.addEventListener('input', () => {
        if (password.value !== password_confirmation.value) {
            password_confirmation.setCustomValidity('Password tidak sama');
        } else {
            password_confirmation.setCustomValidity('');
        }
    });

    // set minimal password length
    password.addEventListener('input', () => {
        if (password.value.length < 8) {
            password.setCustomValidity('Password minimal 8 karakter');
        } else {
            password.setCustomValidity('');
        }
    });




</script>
