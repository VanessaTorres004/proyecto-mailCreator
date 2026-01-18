@extends('layouts.app')

@section('content')
@include('components.breadcrumb', compact('breadcrumbs'))

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/image-picker/image-picker.css') }}" />
<link rel="stylesheet" href="{{ asset('css/sending.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap-fileupload/bootstrap-fileupload.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css') }}" />
@endpush


<div class="container p-3">
  <div class="row">
    <div class="col-lg-12 mx-auto">
      <div class="card">
        <div class="card-header">
          <h4 class="mb-0">Escoge un diseño</h4>
        </div>
        <div class="card-body" id="choose-design">
          <div class="col-md-12">
            <select id="type">
              @for($i = 1; $i <= 11; $i++) <option value="{{ $i }}"
                data-img-src="{{ asset('img/examples/'.$i.'.png') }}">
                </option>
                @endfor
            </select>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <button type="button" class="btn"
                  onclick="window.location.href='{{ url('blocks/list/' . session('campaign_id')) }}'">Cancelar</button>
                <input type="button" class="btn btn-primary" id="next" value="Siguiente">
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="row" id="edit-design" style="display:none">
  <table style="margin: 0 auto" id="content_table_send"></table>
  <form action="{{ url('blocks/add') }}" class="form-horizontal" id="validation-form" method="post"
    enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="type_selected" id="type_selected" value="">
    <div id="form" class="col-md-10 col-md-offset-2"></div>
    <div class="form-group">
      <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        <button type="button" class="btn" onclick="window.location.href='{{ url('campaigns/list') }}'">Cancelar</button>
        <input type="submit" class="btn btn-primary" value="Guardar">
      </div>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('assets/image-picker/image-picker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/buildHtml.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}"></script>
<script type="text/javascript">
  $('#type').imagepicker();
  $(document).ready(function () {
    //console.log("hola");
    $('.wysihtml5').wysihtml5();
    $('#next').click(function () {
      console.log("entro aqui");
      $('#type_selected').val($('#type').val());
      $('#content_table_send').append(getHtml($('#type').val(), "{{asset('/img/sending/')}}"));
      $('.wysihtml5').wysihtml5();
      $('#form').html(getForm($('#type').val()));
      $('#choose-design').hide('fast');
      $('#edit-design').show('fast');
      $('#title').blur(function () {
        $('#title_type_1').html($(this).val());
      });
      $('#link').blur(function () {
        $('#title_type_1').prop('href', $(this).val());
      });
      $('#content').blur(function () {
        $('#content_mail_1').html($('#content').data("wysihtml5").editor.getValue());
      });
      $('#principal').focus(function () {
        $('#content_mail_1').html($('#content').data("wysihtml5").editor.getValue());
      });
      $('#principal').blur(function () {

        $('#button_1').prop('href', $(this).val());
      });
      $('#name-principal').blur(function () {
        $('#button_1').html($(this).val());
      });
      $('#secondary').blur(function () {
        $('#button_2').prop('href', $(this).val());
      });
      $('#name-secondary').blur(function () {
        $('#button_2').html($(this).val());
      });
      $('#title_2').blur(function () {
        $('#title_type_2').html($(this).val());
      });
      $('#subtitle_2').blur(function () {
        $('#subtitle').html($(this).val());
      });
      $('#link_2').blur(function () {
        $('#title_2').prop('href', $(this).val());
      });
      $('#content_2').blur(function () {
        $('#content_view_2').html($(this).val());
      });
      $('#boton_1').focus(function () {
        $('#content_view_2').html($('#content_2').data("wysihtml5").editor.getValue());
      });
      $('#boton_1').blur(function () {
        $('#button_2_1').prop('href', $(this).val());
      });
      $('#name-boton_1').blur(function () {
        $('#button_2_1').html($(this).val());
      });
      $('#boton_2').blur(function () {
        $('#button_2_2').prop('href', $(this).val());
      });
      $('#name-boton_2').blur(function () {
        $('#button_2_2').html($(this).val());
      });
      $('#title_form_3').blur(function () {
        $('#link_3').html($(this).val());
      });
      $('#subtitle_form_3').blur(function () {
        $('#subtitle_3').html($(this).val());
      });
      $('#link_form_3').blur(function () {
        $('#link_3').prop('href', $(this).val());
      });
      $('#content_form_3').blur(function () {
        $('#content_3').html($(this).val());
      });
      $('#boton_form_1').focus(function () {
        $('#content_3').html($('#content_form_3').data("wysihtml5").editor.getValue());
      });
      $('#boton_form_1').blur(function () {
        $('#button_3_1').prop('href', $(this).val());
      });
      $('#name-boton_form_1').blur(function () {
        $('#button_3_1').html($(this).val());
      });
      $('#boton_form_2').blur(function () {
        $('#button_3_2').prop('href', $(this).val());
      });
      $('#name-boton_form_2').blur(function () {
        $('#button_3_2').html($(this).val());
      });
      //replace data on 4
      $('#title_left_form').blur(function () {
        $('#link_left').html($(this).val());
      });
      $('#link_form_left').blur(function () {
        $('#image_link_left').prop('href', $(this).val());
        $('#link_left').prop('href', $(this).val());
        $('#learn_more_left').prop('href', $(this).val());
      });
      $('#content_left_form').blur(function () {
        $('#content_left').html($(this).val());
      });
      $('#link_form_right').focus(function () {
        $('#content_left').html($('#content_left_form').data("wysihtml5").editor.getValue());
      });
      $('#title_right_form').blur(function () {
        $('#link_right').html($(this).val());
      });
      $('#link_form_right').blur(function () {
        $('#image_link_right').prop('href', $(this).val());
        $('#link_right').prop('href', $(this).val());
        $('#learn_more_right').prop('href', $(this).val());
      });
      $('#content_right_form').blur(function () {
        $('#content_right').html($(this).val());
      });
      $('#link_form_right').focus(function () {
        $('#content_right').html($('#content_right_form').data("wysihtml5").editor.getValue());
      });
      //replace data on 5
      $('#title_1_form').blur(function () {
        $('#title_1').html($(this).val());
      });
      $('#title_2_form').blur(function () {
        $('#title_2').html($(this).val());
      });
      $('#title_3_form').blur(function () {
        $('#title_3').html($(this).val());
      });
      $('#link_form_1').blur(function () {
        $('.link_1').prop('href', $(this).val());
      });
      $('#link_form_2').blur(function () {
        $('.link_2').prop('href', $(this).val());
      });
      $('#link_form_3').blur(function () {
        $('.link_3').prop('href', $(this).val());
      });
      $('#link_form_3').focus(function () {
        $('#content_1').html($('#content_1_form').data("wysihtml5").editor.getValue());
        $('#content_2').html($('#content_2_form').data("wysihtml5").editor.getValue());
        $('#content_3').html($('#content_3_form').data("wysihtml5").editor.getValue());
      });
      $('#content_1_form').blur(function () {
        $('#content_1').html($(this).val());
      });
      $('#content_2_form').blur(function () {
        $('#content_2').html($(this).val());
      });
      $('#content_3_form').blur(function () {
        $('#content_3').html($(this).val());
      });
      //Replace data on 6
      $('#title-form').blur(function () {
        $('#title').html($(this).val());
      });
      $('#link-form').blur(function () {
        $('.link').prop('href', $(this).val());
      });
      $('#content-form').blur(function () {
        $('#content').html($(this).val());
      });
      $('#name-boton-form').blur(function () {
        $('#button').html($(this).val());
      });
      $('#name-boton-form').focus(function () {
        $('#content').html($('#content-form').data('wysihtml5').editor.getValue());
      });
      //replace data on 7
      $('#date-form').blur(function () {
        $('#date').html($(this).val());
      });
      $('#link1-form').blur(function () {
        $('#link_1').prop('href', $(this).val());
      });
      $('#link2-form').blur(function () {
        $('#link_2').prop('href', $(this).val());
      });
      $('#link3-form').blur(function () {
        $('#link_3').prop('href', $(this).val());
      });
      $('#link4-form').blur(function () {
        $('#link_4').prop('href', $(this).val());
      });
      $('#content1-form').blur(function () {
        $('#content_1').html($(this).val());
      });
      $('#content2-form').blur(function () {
        $('#content_2').html($(this).val());
      });
      $('#content3-form').blur(function () {
        $('#content_3').html($(this).val());
      });
      $('#content4-form').blur(function () {
        $('#content_4').html($(this).val());
      });
      $('#link4-form').focus(function () {
        $('#content_1').html($('#content1-form').data('wysihtml5').editor.getValue());
        $('#content_2').html($('#content2-form').data('wysihtml5').editor.getValue());
        $('#content_3').html($('#content3-form').data('wysihtml5').editor.getValue());
        $('#content_4').html($('#content4-form').data('wysihtml5').editor.getValue());
      });

      //replace data on 8
      $('#name-link-form').focus(function () {
        $('#content').html($('#content-form').data('wysihtml5').editor.getValue());
      });
      //replace data on 9
      $('#title-form').blur(function () {
        $('#title').html($(this).val());
      });
      $('#content-form').blur(function () {
        $('#content').html($(this).val());
      });
      $('#link-form').blur(function () {
        $('.link').prop('href', $(this).val());
      });
      $('#name-link-form').blur(function () {
        $('#link-name').html($(this).val());
      });
      $('#day-form').blur(function () {
        $('#day').html($(this).val());
      });
      $('#day-form').focus(function () {
        $('#content').html($('#content-form').data('wysihtml5').editor.getValue());
      });
      $('#month-form').blur(function () {
        $('#month').html($(this).val());
      });
    });
  });
</script>
@stop