<x-guest-layout>
    <div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">

						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">Forgot Password?</h3>

									</div>
									<div class="d-grid">
										<div class="text-center">
                                            <img src="assets/images/icons/mms.png" width="160" alt="" />
                                        </div>
									</div>
									<div class="login-separater text-center mb-4"> <span>  {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</span>
										<hr/>
									</div>
									<div class="form-body">

                                            <form class="row g-3" method="POST" action="{{ route('password.email') }}">
                                                @csrf
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Email Address</label>
												<input type="email" class="form-control" id="email" name="email" :value="old('email')" required autofocus placeholder="Email Address">
											</div>


											<div class="col-md-6 text-end">	<a href="{{ route('login') }}">Or login</a>
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>{{ __('Email Password Reset Link') }}</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
</x-guest-layout>
