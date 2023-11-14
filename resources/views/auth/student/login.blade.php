<x-guest-layout>
    <!-- Session Status -->
    <x-status-message />
    <div class="wrapper-page">
        <h4 class="text-muted text-center font-size-18"><b>Student Sign In</b></h4>
        <div class="p-3">
            <form class="form-horizontal mt-3" method="POST" action="{{ route('student.loginPost') }}">
                @csrf
                <div class="form-group mb-3 row">
                    <div class="col-12">
                        <div>
                            <x-text-input id="login" class="form-control" type="text" name="login"
                                :value="old('login')" required autofocus autocomplete="username"
                                placeholder="Email or Aadhar Number" />
                            <x-input-error :messages="$errors->get('login')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3 text-center row mt-3 pt-1">
                    <div class="col-12">
                        <button class="btn btn-info w-100 waves-effect waves-light" type="submit">
                            {{ __('Log in') }}</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- end -->
        <!-- end container -->
    </div>
</x-guest-layout>
