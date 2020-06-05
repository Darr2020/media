/*
* Form Validation
*/
$(function() {
  $("#svcat").validate({
    rules: {
      nomCatg: {
        required: true,
        minlength: 3
      },
      desCateg: {
        required: true,
        minlength: 5
      },
      desCand: {
        required: true,
        minlength: 5
      },
      nombre: "required",
    },
    //For custom messages
    messages: {
      nomCatg: {
        required: "Escriba un nombre para la categoría",
        minlength: "Minimo 3 caracteres"
      },
      desCateg: {
        required: "Escriba una descripción para la categoría",
        minlength: "Minimo 5 caracteres"
      },
      desCand: {
        required: "Escriba el tipo de candidato u opción para la categoría",
        minlength: "Minimo 5 caracteres"
      },
    },
    errorElement: 'div',
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
  });
});