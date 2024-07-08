<section>
    <div x-data="{ openModal: false }" x-show="openModal"
        class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-75">
        <div>
            <form method="post" action="{{ route('profile.destroy') }}" class="mt-6">
                @csrf
                @method('delete')

                <div class="mb-3">
                    <label class="form-label" for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                    <input class="form-control" id="password" style="width: 400px;" name="password" type="password"
                        placeholder="{{ __('Password') }}" required>
                    @if ($errors->userDeletion->has('password'))
                        <span class="text-red-600 text-sm">{{ $errors->userDeletion->first('password') }}</span>
                    @endif
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="btn btn-danger mt-2">{{ __('Delete Account') }}</button>
                </div>
            </form>
        </div>
    </div>
</section>