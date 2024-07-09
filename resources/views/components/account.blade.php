<div class="body flex-grow-1">
    <div class="container-lg px-4">
        <div class="row g-4 mb-4">
            <!-- Table -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Change Profile Detail</div>
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
