@extends('cms.parent')

@section('page-name','Create Posts')
@section('main-page','Content Management')
@section('sub-page','Posts')
@section('page-name-small','Create Posts')
@section('title','Create Posts')
@section('styles')


@endsection

@section('content')
<!--begin::Container-->
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">Horizontal Form Layout</h3>
            </div>
            <!--begin::Form-->
            <form id="create-form">
                @csrf
                <div class="card-body">

                    <h3 class="text-dark font-weight-bold mb-10">Basic Info</h3>

                    <div class="form-group row mt-4">
                        <label for="name" class="col-3 col-form-label">title:</label>
                        <div class="col-6">
                            <input name="title" type="text" class="form-control" id="title" placeholder="Please enter your title" />

                            <span class="form-text text-muted">Please enter name</span>
                        </div>
                        <div class="col-6">
                            <input name="type" type="hidden" class="form-control" id="type" value="create" />

                        </div>
                    </div>
                    <div class="separator separator-dashed my-10"></div>

                    <h3 class="text-dark font-weight-bold mb-10">Image</h3>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Image:<span class="text-danger">*</span></label>
                        <div class="form-group">
                            <label for="title">Choose Image</label>
                            <input type="file" id="image" name="image" accept="image/*" onchange="previewFile(this);" /><br/>
                            </p>
                            <img id="previewImg" src={{asset('cms/assets/media/users/blank.png')}} width="100px" height="100px" alt="Placeholder">
                            <p>
                        </div>
                    </div>

                    <h3 class="text-dark font-weight-bold mb-10">Date</h3>
                    <div class="form-group row mt-4">
                        <label class="col-3 col-form-label">Date:</label>
                        <div class="col-3">
                            <input name="date" type="date" class="form-control" id="example-date-input" placeholder="Enter date" />
                            <span class="form-text text-muted">Please enter date</span>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-10"></div>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-3">

                        </div>
                        <div class="col-9">
                            <button type="button" onclick="store()" class="btn btn-primary mr-2">Submit</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
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
        function previewFile(input){
            var file = $("input[type=file]").get(0).files[0];

            if(file){
                var reader = new FileReader();
                reader.onload = function(){
                    $("#previewImg").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }
</script>

<script>
     function store() {
         let formData = new FormData($('#create-form')[0]);
             axios.post('/admin/dashboard/posts', formData, {
                 headers: {
                     'Content-Type': 'application/json',
                     'Accept': 'application/json',
                 }
             }).then(function (response) {
                 console.log(response);
                 toastr.success(response.data.message);
                 window.location.href = '/admin/dashboard/posts';
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
