@extends('cms.parent')

@section('page-name','Edit Admin')
@section('main-page','Human Resources')
@section('sub-page','Admins')
@section('page-name-small','Edit Admin')
@section('title','Edit Admin')

@section('styles')

@endsection

@section('content')
<!--begin::Container-->
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">{{__('admin.Edit_Admin')}} </h3>
                {{-- <div class="card-toolbar">
                        <div class="example-tools justify-content-center">
                            <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                            <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                        </div>
                    </div> --}}
            </div>
            <!--begin::Form-->
            <form id="create-form">
                <div class="card-body">
                    <h3 class="text-dark font-weight-bold mb-10">{{__('admin.Role')}}</h3>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">{{__('admin.Role')}}:<span class="text-danger">*</span></label>
                        <div class="col-lg-4 col-md-9 col-sm-12">
                            <div class="dropdown bootstrap-select form-control dropup">
                                <select class="form-control selectpicker" data-size="7" id="role_id"
                                    title="{{__('admin.Please_select_role')}}" tabindex="null" data-live-search="true">
                                    @foreach ($roles as $role)
                                    <option value="{{$role->id}}" @if($adminRole->id == $role->id) selected
                                        @endif>{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="form-text text-muted">{{__('admin.Please_select_role')}}</span>
                        </div>
                    </div>

                    <div class="separator separator-dashed my-10"></div>
                    <h3 class="text-dark font-weight-bold mb-10">{{__('admin.Basic_Info')}}</h3>
                    <div class="form-group row mt-4">
                        <label class="col-3 col-form-label">{{__('admin.Full_Name')}}:<span class="text-danger">*</span></label>
                        <div class="col-9">
                            <input type="hidden" class="form-control" id="id" value="{{$admin->id}}"/>
                            <input type="text" class="form-control" id="name" value="{{$admin->name}}"
                                placeholder="{{__('admin.Enter_full_name')}}" />
                            <span class="form-text text-muted">{{__('admin.Please_enter_your_full_name')}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">{{__('admin.Email_address')}}:<span class="text-danger">*</span></label>
                        <div class="col-9">
                            <input type="email" class="form-control" id="email" value="{{$admin->email}}"
                                placeholder="{{__('admin.Enter_email')}}" />
                            <span class="form-text text-muted">{{__('admin.Please_enter_your_email_address')}}</span>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-3">

                        </div>
                        <div class="col-9">
                            <button type="button" onclick="update('{{$admin->id}}')" class="btn btn-primary mr-2">{{__('admin.Save_Edit')}}</button>
                            <button type="reset" class="btn btn-secondary">{{__('admin.Cancel')}}</button>
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
    function update(id) {
        axios.put('/admin/dashboard/admins/'+id,{
            role_id: document.getElementById('role_id').value,
            id: document.getElementById('id').value,
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
        }).then(function (response) {
            // handle success
            console.log(response);
            toastr.success(response.data.message);
            window.location.href = '/admin/dashboard/admins';
        }).catch(function (error) {
            console.log(error);
            let messages = '';
            for (const [key, value] of Object.entries(error.response.data.message)) {
                messages+='-'+value+'</br>';
            }
            toastr.error(messages);
        });
    }
</script>

@endsection
