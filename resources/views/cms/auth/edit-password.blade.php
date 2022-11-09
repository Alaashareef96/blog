@extends('cms.parent')

@section('content')
<!--begin::Content-->
<div class="flex-row-fluid ml-lg-8">
    <!--begin::Card-->
    <div class="card card-custom">
        <!--begin::Header-->
        <div class="card-header py-3">
            <div class="card-title align-items-start flex-column">
                <h3 class="card-label font-weight-bolder text-dark">تغيير كلمة المرور</h3>
                <span class="text-muted font-weight-bold font-size-sm mt-1">تغيير كلمة مرور حسابك</span>
            </div>
            <div class="card-toolbar">
                <button type="button" onclick="updatePassword()" class="btn btn-success mr-2">حفظ التغيرات</button>
                <button type="reset" class="btn btn-secondary">الغاء</button>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form class="form" id="create-form">
            <div class="card-body">
                <!--begin::Alert-->
{{--                <div class="alert alert-custom alert-light-danger fade show mb-10" role="alert">--}}
{{--                    <div class="alert-icon">--}}
{{--                        <span class="svg-icon svg-icon-3x svg-icon-danger">--}}
{{--                            <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Info-circle.svg-->--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"--}}
{{--                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">--}}
{{--                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
{{--                                    <rect x="0" y="0" width="24" height="24" />--}}
{{--                                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />--}}
{{--                                    <rect fill="#000000" x="11" y="10" width="2" height="7" rx="1" />--}}
{{--                                    <rect fill="#000000" x="11" y="7" width="2" height="2" rx="1" />--}}
{{--                                </g>--}}
{{--                            </svg>--}}
{{--                            <!--end::Svg Icon-->--}}
{{--                        </span>--}}
{{--                    </div>--}}
{{--                    <div class="alert-text font-weight-bold">Configure user passwords to expire periodically. Users will--}}
{{--                        need warning that their passwords are going to expire,--}}
{{--                        <br />or they might inadvertently get locked out of the system!</div>--}}
{{--                    <div class="alert-close">--}}
{{--                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--                            <span aria-hidden="true">--}}
{{--                                <i class="ki ki-close"></i>--}}
{{--                            </span>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <!--end::Alert-->
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label text-alert">كلمة المرور القديمة</label>
                    <div class="col-lg-9 col-xl-6">
                        <input type="password" class="form-control form-control-lg form-control-solid mb-2"
                            id="current_password" value="" placeholder="كلمة المرور القديمة" />
                        {{-- <a href="#" class="text-sm font-weight-bold">Forgot password ?</a> --}}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label text-alert">كلمة المرور الجديدة</label>
                    <div class="col-lg-9 col-xl-6">
                        <input type="password" class="form-control form-control-lg form-control-solid" value=""
                            id="password" placeholder="كلمة المرور الجديدة" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label text-alert">تأكيد كلمة المرور الجديدة</label>
                    <div class="col-lg-9 col-xl-6">
                        <input type="password" class="form-control form-control-lg form-control-solid" value=""
                            id="password_confirmation" placeholder="تأكيد كلمة المرور" />
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
</div>
<!--end::Content-->
@endsection

@section('scripts')
    <script>
     function updatePassword(){
      axios.put('/admin/user/password',{

        current_password:document.getElementById('current_password').value,
        password:document.getElementById('password').value,
        password_confirmation:document.getElementById('password_confirmation').value,
      }).then(function (response) {
    // handle success
      console.log(response);
      document.getElementById('create-form').reset();
       // toastr.success(response.data.message);
          Swal.fire({
              icon: 'success',
              title: 'تم التحديث بنجاح',
              showConfirmButton: false,
              timer: 1500
          })
  }).catch(function (error) {
          let messages = '';
          if(typeof  error.response.data.message == 'string'){
              toastr.error(error.response.data.message);
          }else{
              for (const [key, value] of Object.entries(error.response.data.message)) {
                  messages+='-'+value+'</br>';
              }
              toastr.error(messages);
          }

      });

     }

    </script>
@endsection
