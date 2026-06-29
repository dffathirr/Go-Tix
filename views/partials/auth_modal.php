<!-- Auth Modal -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-white text-dark border-0 rounded-4 shadow-lg p-2">
            <div class="modal-header border-0 pb-0 justify-content-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-5 pb-5 pt-0">
                
                <!-- Alert for errors -->
                <div id="authAlert" class="alert alert-danger d-none mb-4" role="alert"></div>

                <!-- Login Section -->
                <div id="loginSection">
                    <p class="text-primary-light fw-bold mb-1 small text-uppercase" style="letter-spacing: 1px;">SUDAH PUNYA AKUN?</p>
                    <h2 class="fw-bold text-dark mb-2">Masuk</h2>
                    <div class="bg-primary-light mb-4" style="height: 3px; width: 60px;"></div>

                    <form id="loginForm">
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <div class="position-relative">
                                    <input type="email" class="form-control bg-white border py-3 pe-5" id="loginEmail" name="email" placeholder="Email*" required>
                                    <i class="fa-regular fa-envelope position-absolute top-50 end-0 translate-middle-y me-3 text-secondary"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="position-relative">
                                    <input type="password" class="form-control bg-white border py-3 pe-5" id="loginPassword" name="password" placeholder="Kata Sandi*" required>
                                    <i class="fa-regular fa-eye-slash position-absolute top-50 end-0 translate-middle-y me-3 text-secondary" style="cursor: pointer;" onclick="togglePassword('loginPassword', this)"></i>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                            <span class="text-secondary">Tidak Memiliki Akun? <a href="javascript:void(0)" class="text-primary-light text-decoration-none fw-medium" onclick="switchAuthView('register')">Daftar</a></span>
                            <a href="#" class="text-primary-light text-decoration-none fw-medium">Lupa password</a>
                        </div>

                        <button type="submit" class="btn bg-primary-light text-white fw-bold py-2 px-4 shadow-sm d-inline-flex align-items-center gap-2 rounded-2">
                            MASUK <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>
                </div>

                <!-- Register Section -->
                <div id="registerSection" class="d-none">
                    <p class="text-primary-light fw-bold mb-1 small text-uppercase" style="letter-spacing: 1px;">BUAT AKUN BARU?</p>
                    <h2 class="fw-bold text-dark mb-2">Daftar Akun</h2>
                    <div class="bg-primary-light mb-4" style="height: 3px; width: 80px;"></div>

                    <form id="registerForm">
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <div class="position-relative">
                                    <input type="text" class="form-control bg-white border py-3 pe-5" id="regNama" name="nama" placeholder="Nama*" required>
                                    <i class="fa-regular fa-user position-absolute top-50 end-0 translate-middle-y me-3 text-secondary"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="position-relative">
                                    <input type="email" class="form-control bg-white border py-3 pe-5" id="regEmail" name="email" placeholder="Email*" required>
                                    <i class="fa-regular fa-envelope position-absolute top-50 end-0 translate-middle-y me-3 text-secondary"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="position-relative">
                                    <input type="password" class="form-control bg-white border py-3 pe-5" id="regPassword" name="password" placeholder="Kata Sandi*" required>
                                    <i class="fa-regular fa-eye position-absolute top-50 end-0 translate-middle-y me-3 text-secondary" style="cursor: pointer;" onclick="togglePassword('regPassword', this)"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="position-relative">
                                    <input type="text" class="form-control bg-white border py-3 pe-5" id="regNoHp" name="no_hp" placeholder="No Telp*" required>
                                    <i class="fa-solid fa-phone position-absolute top-50 end-0 translate-middle-y me-3 text-secondary"></i>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                            <span class="text-secondary">Sudah Memiliki Akun? <a href="javascript:void(0)" class="text-primary-light text-decoration-none fw-medium" onclick="switchAuthView('login')">Masuk</a></span>
                        </div>

                        <button type="submit" class="btn bg-primary-light text-white fw-bold py-2 px-4 shadow-sm d-inline-flex align-items-center gap-2 rounded-2">
                            DAFTAR <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
// Expose functions to global scope for onclick attributes
window.switchAuthView = function(view) {
    const loginSection = document.getElementById('loginSection');
    const registerSection = document.getElementById('registerSection');
    const authAlert = document.getElementById('authAlert');
    
    // Hide alert when switching views
    if(authAlert) authAlert.classList.add('d-none');

    if (view === 'login') {
        loginSection.classList.remove('d-none');
        registerSection.classList.add('d-none');
    } else {
        loginSection.classList.add('d-none');
        registerSection.classList.remove('d-none');
    }
};

window.togglePassword = function(inputId, iconElement) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        iconElement.classList.remove('fa-eye-slash');
        iconElement.classList.add('fa-eye'); // or keep it depending on UX preference, let's toggle icon
    } else {
        input.type = 'password';
        iconElement.classList.remove('fa-eye');
        iconElement.classList.add('fa-eye-slash');
    }
};

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const authAlert = document.getElementById('authAlert');

    const handleAuth = async (form, actionUrl) => {
        authAlert.classList.add('d-none');
        const formData = new FormData(form);

        try {
            const response = await fetch(actionUrl, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                // Reload the page on success
                window.location.reload();
            } else {
                authAlert.textContent = result.message;
                authAlert.classList.remove('d-none');
            }
        } catch (error) {
            authAlert.textContent = 'Terjadi kesalahan pada sistem.';
            authAlert.classList.remove('d-none');
        }
    };

    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            handleAuth(loginForm, '/gotix-php/auth/login');
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', (e) => {
            e.preventDefault();
            handleAuth(registerForm, '/gotix-php/auth/register');
        });
    }
});
</script>
