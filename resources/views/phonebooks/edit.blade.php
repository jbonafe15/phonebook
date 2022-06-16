@extends('phonebooks.layout')
@section('content')
 
<div class="card mt-5">
  <div class="card-header">Edit</div>
  <div class="card-body">
      <form action="{{ url('phonebook/' .$phonebook->id) }}" method="post" id='formUpdate'>
        {!! csrf_field() !!}
        @method("PATCH")
        <input type="hidden" name="id" id="id" value="{{$phonebook->id}}" id="id" />
        <label>Title</label></br>
        <input type="text" name="title" id="title" value="{{$phonebook->title}}" class="form-control"></br>
        <label>Firstname</label></br>
        <input type="text" name="firstname" id="firstname" value="{{$phonebook->firstname}}" class="form-control"></br>
        <label>Lastname</label></br>
        <input type="text" name="lastname" id="lastname" value="{{$phonebook->lastname}}" class="form-control"></br>
        <label>Mobile Number</label></br>
        <input type="text" name="mobile" id="mobile" value="{{$phonebook->mobile}}" maxlength="11" class="form-control"></br>
        <label>Company Name</label></br>
        <input type="text" name="company" id="company" value="{{$phonebook->company}}" class="form-control"></br>
        <input type="submit" value="Update" id='btnUpdate' class="btn btn-success"></br>
    </form>
   
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>

<script>
  $('#btnUpdate').click(function(e) {
    e.preventDefault();
    var firstname = $('#firstname');
    var lastname = $('#lastname');
    var title = $('#title');
    var mobile = $('#mobile');
    var company = $('#company');
    var isValid = true;

    if (firstname.val() == '') {
      firstname.addClass('is-invalid');
      isValid = false;
    }

    if (lastname.val() == '') {
      lastname.addClass('is-invalid');
      isValid = false;
    }

    if (title.val() == '') {
      title.addClass('is-invalid');
      isValid = false;
    }
    
    if (mobile.val() == '') {
      mobile.addClass('is-invalid');
      isValid = false;
    } else if (!validateMobile(mobile.val())) {
        mobile.addClass('is-invalid');
        isValid = false;
    }

    if (company.val() == '') {
      mobile.addClass('is-invalid');
      isValid = false;
    }
    
    if (isValid) {
      $('#formUpdate').submit();
    }
  });

  function validateMobile(mobile) {
    var phone_pattern = /^[0-9]*$/; 
    return phone_pattern.test(mobile);
  }

  $(document.body).on("blur", "input, .form-control", function () {
      $(this).removeClass("is-invalid");
  });
</script>
@stop