<div class="col-md-8 align-items-center">
    <div class="card">
        <form wire:submit="attachOrganizations" role="form" method="POST" action={{ route('welcome.update') }}
            enctype="multipart/form-data">
            @csrf
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <p class="mb-0">Edit Profile</p>
                </div>
            </div>
            <div class="card-body">
                <p class="text-uppercase text-sm">User Information</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Name</label>
                            <input class="form-control" type="text" name="name" id="name"
                                value="{{ old('name', auth()->user()->name) }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Email address</label>
                            <input class="form-control" type="email" name="email"
                                value="{{ old('email', auth()->user()->email) }}" disabled>
                        </div>
                    </div>
                </div>
                <hr class="horizontal dark">
                <p class="text-uppercase text-sm">About me</p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Bio</label>
                            <textarea wire:model="bio" class="form-control" type="text" name="bio" id="bio"
                                value="{{ old('bio', auth()->user()->bio) }}" placeholder="Please enter something about yourself." required></textarea>
                            @error('bio')
                                <p class="p text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {{-- <div class="form-group">
                                <label for="organizations" class="form-control-label">Organizations</label>
                                <select class="form-select" id="organizations" name="organizations[]" multiple aria-label="Select organizations">
                                    @foreach ($organizations as $organization)
                                        <option value="{{ $organization->id }}" {{ in_array($organization->id, old('organizations', [])) ? 'selected' : '' }}>
                                            {{ $organization->nickname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                        <div x-data="{
                            selectedOrganizations: @entangle('selectedOrganizations'),
                            organizations: @entangle('organizations'),
                            removeOrganization(id) {
                                this.selectedOrganizations = this.selectedOrganizations.filter(orgId => orgId !== id);
                            }
                        }" class="form-group">

                            <label for="organization" class="form-control-label">Organization</label>
                            <select
                                x-on:change="selectedOrganizations.push($event.target.value); $event.target.value = ''"
                                class="form-select" id="organization" aria-label="Select organization" required>
                                <option value="" disabled selected>Select an organization...</option>
                                <template x-for="(name, id) in organizations" :key="id">
                                    <option :value="id" x-text="name"
                                        :disabled="selectedOrganizations.includes(id)">
                                    </option>
                                </template>
                            </select>
                            @error('selectedOrganizations')
                                <p class="p text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            <div class="mt-3">
                                <h5>Selected Organizations:</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    <template x-for="id in selectedOrganizations" :key="id">
                                        <div class="d-flex align-items-center">
                                            <span x-text="organizations[id]"
                                                class="badge bg-primary me-1 p-2 cursor-pointer"
                                                x-on:click="removeOrganization(id)">
                                                &times;
                                            </span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 align-items-center">
                        <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3 mt-3">
                            <button type="submit"
                                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-3 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Join
                                the Community!</button>
                        </div>
                    </div>
                    {{-- USERS POSTS LIST/HISTORY END --}}
                </div>
            </div>
        </form>
    </div>

</div>
