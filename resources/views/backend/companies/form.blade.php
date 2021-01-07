@extends('backend/layout')
@section('content')
    <section class="content-header">
        <h1>Company</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">{{ $company->page_title }}</li>
        </ol>
    </section>
    <!-- Main content -->
    <section id="main-content" class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ $company->page_title }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{ Form::open(array('route' => $company->form_action, 'method' => 'POST', 'files' => true,'enctype'=>'multipart/form-data', 'id' => 'company-form')) }}
                        {{ Form::hidden('id', $company->id, array('id' => 'company_id')) }}
                        <div id="form-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Name</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('name', $company->name, array('class' => 'form-control validate[required, regex[/^[\w-]*$/], string, maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11','placeholder'=>'Company Name')) }}
                            </div>
                        </div>
                        <div id="form-email" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Email</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                 {{ Form::email('email', $company->email, array('class' => 'form-control validate[required, custom[email], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11','placeholder'=>'Company Email')) }}
                            </div>
                        </div>
                        <div id="form-postcode" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Postcode</strong>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-content">
                                 {{ Form::number('postcode', $company->postcode, array('class' => 'form-control validate[required, custom[number],minSize[7] , maxSize[7]]', 'data-prompt-position' => 'bottomLeft:0,11','placeholder'=>'Postcode')) }}
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 col-content">
                                <button class="btn btn-info" id="search">Search</button>
                            </div>
                        </div>
                        <div id="form-prefecture_id" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Perfecture</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                 {{ Form::select('prefecture_id',[''=>'Select Prefecture']+ \App\Models\Prefecture::pluck('display_name','id')->all(), $company->prefecture_id, array('class' => 'form-control validate[required]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            </div>
                        </div>
                        <div id="form-city" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">City</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('city', $company->city, array('class' => 'form-control validate[required, regex[/^[\w-]*$/], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11','placeholder'=>'City')) }}
                            </div>
                        </div>
                        <div id="form-local" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Local</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('local', $company->local, array('class' => 'form-control validate[required, regex[/^[\w-]*$/], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11','placeholder'=>'Local')) }}
                            </div>
                        </div>
                        <div id="form-street_address" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Street Address</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('street_address', $company->street_address, array('class' => 'form-control validate[regex[/^[\w-]*$/], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11','placeholder'=>'Company Address')) }}
                            </div>
                        </div>
                        <div id="form-business_hour" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Business Hour</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('business_hour', $company->business_hour, array('class' => 'form-control validate[regex[/^[\w-]*$/], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            </div>
                        </div>
                        <div id="form-regular_holiday" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Regular Holiday</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('regular_holiday', $company->regular_holiday, array('class' => 'form-control validate[regex[/^[\w-]*$/], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            </div>
                        </div>
                        <div id="form-phone" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Phone</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('phone', $company->phone, array('class' => 'form-control validate[custom[phone], maxSize[14]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            </div>
                        </div>
                        <div id="form-fax" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Fax</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('fax', $company->fax, array('class' => 'form-control validate[custom[phone], maxSize[14]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            </div>
                        </div>
                        <div id="form-url" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">URL</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('url', $company->url, array('class' => 'form-control validate[custom[url], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11','placeholder'=>'ex: https://mycompany.com')) }}
                            </div>
                        </div>
                        <div id="form-license_number" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">License Number</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('license_number', $company->license_number, array('class' => 'form-control validate[ maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11','placeholder'=>'License number')) }}
                            </div>
                        </div>
                        <div id="form-image" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                @if($company->page_type=='create')
                                    <span class="label label-danger label-required">Required</span>
                                @endif
                                <strong class="field-title">Image</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                @if($company->page_type == 'create')
                                {{ Form::file('image', array('class' => 'form-control validate[required, maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11','placeholder'=>'License number')) }}
                                    @else
                                {{ Form::file('image', array('class' => 'form-control validate[]', 'data-prompt-position' => 'bottomLeft:0,11','placeholder'=>'License number')) }}
                                @endif
                                @if(!empty($company->image))
                                        <img src="{{ asset('uploads/files/').'/'.$company->image }}" alt="Company Image" width="250px">
                                    @endif
                            </div>
                        </div>
                        <div id="form-button" class="form-group no-border">
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="margin-top: 20px;">
                                <button type="submit" name="submit" id="send" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('title', 'Company | ' . env('APP_NAME',''))

@section('body-class', 'custom-select')

@section('css-scripts')
@endsection

@section('js-scripts')
    <script src="{{ asset('bower_components/bootstrap/js/tooltip.js') }}"></script>
    <!-- validationEngine -->
    <script src="{{ asset('js/3rdparty/validation-engine/jquery.validationEngine-en.js') }}"></script>
    <script src="{{ asset('js/3rdparty/validation-engine/jquery.validationEngine.js') }}"></script>
    <script src="{{ asset('js/backend/companies/form.js') }}"></script>
    <script>
        $('#search').on('click',function (e) {
            e.preventDefault()
            checkPostcode()
        })
        function checkPostcode() {
            $.ajax({
                url:"{{ route('postcode.check') }}",
                type:'POST',
                data:{
                    _token:"{{ csrf_token() }}",
                    postcode:$('[name=postcode]').val()
                },success:function (s) {
                   if(s!=='error'){
                       $('[name=prefecture_id] option:selected').removeAttr('selected')
                       $('[name=prefecture_id]').val(s.prefecture_id)
                       $('[name=city]').val(s.city)
                       $('[name=local]').val(s.local)
                   }
                }
            })
        }
    </script>
@endsection
