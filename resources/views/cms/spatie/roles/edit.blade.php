@extends('cms.parent')

@section('page-name',__('role.Edit_Role'))
@section('main-page',__('role.Roles_Permissions'))
@section('sub-page',__('role.Roles'))
@section('page-name-small',__('role.Edit_Role'))

@section('styles')

@endsection

@section('content')
<!--begin::Container-->
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">{{__('role.Edit_Role')}}</h3>
                {{-- <div class="card-toolbar">
                        <div class="example-tools justify-content-center">
                            <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                            <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                        </div>
                    </div> --}}
            </div>
            <!--begin::Form-->
            <form>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-3 col-form-label">{{__('role.Auth_Type')}}:</label>
                        <div class="col-lg-4 col-md-9 col-sm-12">
                            <div class="dropdown bootstrap-select form-control dropup">
                                <select class="form-control selectpicker" data-size="7" id="guard_name"
                                    title="{{__('role.Choose_one_of_the_following')}}" tabindex="null" data-live-search="true">
                                    <option value="admin" @if($role->guard_name == 'admin') selected @endif>{{__('role.Admin')}}
                                    </option>

                                </select>
                            </div>
                            <span class="form-text text-muted">{{__('role.Please_select_auth_type')}}</span>
                        </div>
                    </div>
                    <div class="form-group row mt-4">
                        <label class="col-3 col-form-label">{{__('role.Name')}}</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="name" value="{{$role->name}}"
                                placeholder="{{__('role.Enter_role_name')}}" />
                            <span class="form-text text-muted">{{__('role.Please_enter_role_name')}}</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-3">

                        </div>
                        <div class="col-9">
                            <button type="button" onclick="update('{{$role->id}}')" class="btn btn-primary mr-2">{{__('role.Save_Edit')}}</button>
                            <button type="reset" class="btn btn-secondary">{{__('role.Cancel')}}</button>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Container-->
@endsection

@section('scripts')
    <script>
     function update(id){
        axios.put('/admin/dashboard/roles/'+id,{
        name:document.getElementById('name').value,
        guard:document.getElementById('guard_name').value,
      }).then(function (response) {
    // handle success
      console.log(response);
       toastr.success(response.data.message);
       window.location.href = '/admin/dashboard/roles';
  }).catch(function (error) {
    // handle error
       console.log(error);
       toastr.error(error.response.data.message);
  });

     }

    </script>
@endsection
