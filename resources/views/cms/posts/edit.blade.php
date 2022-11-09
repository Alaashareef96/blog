@extends('cms.parent')

@section('page-name','Edit Posts')
@section('main-page','Content Management')
@section('sub-page','Posts')
@section('page-name-small','Edit Posts')

@section('title','Edit Posts')
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
                                <input name="title" type="text" class="form-control" id="title" value="{{$post->title}}" placeholder="Please enter your title" />
                                <input type="hidden" class="form-control" name="id" value="{{$post->id}}"/>
                                <span class="form-text text-muted">Please enter name</span>
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
                                <img id="previewImg" src="{{url(Storage::url($post->image))}}" width="100px" height="100px" alt="Placeholder">
                                <p>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-10"></div>


                        <h3 class="text-dark font-weight-bold mb-10">Date</h3>
                        <div class="form-group row mt-4">
                            <label class="col-3 col-form-label">Date:</label>
                            <div class="col-3">
                                <input name="date" type="date" value="{{$post->date}}" class="form-control" id="example-date-input" placeholder="Enter date" />
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
                                <button type="button" onclick="update('{{$post->id}}')"class="btn btn-primary mr-2">Submit</button>
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
        function update(id){
            let formData = new FormData($('#create-form')[0]);
            formData.append('_method','PUT');

            axios.post('/admin/dashboard/posts/'+id, formData).then(function (response) {
                // handle success
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
