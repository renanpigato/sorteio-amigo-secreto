/* 
  Created on : 16/07/2015, 11:53:43
  Author     : Rtech sistemas
*/

/*** Varíavel global com erros do formValidator ***/
window.enErrorDialogs = {
  errorTitle: 'Form submission failed!',
  requiredFields: 'Você não preencheu todos os campos requiridos',
  badTime: 'You have not given a correct time',
  badEmail: 'Você não informou um endereço de e-mail válido',
  badTelephone: 'You have not given a correct phone number',
  badSecurityAnswer: 'You have not given a correct answer to the security question',
  badDate: 'Você não informou uma data correta',
  badCpfCnpj: 'Você não inseriu um CPF ou CNPJ válido',
  badCpf: 'Você não inseriu um CPF válido',
  badCnpj: 'Você não inseriu um CNPJ válido',
  lengthBadStart: 'You must give an answer between ',
  lengthBadEnd: ' caracteres',
  lengthTooLongStart: 'Você excedeu o limite de caracteres do campo',
  lengthTooShortStart: 'Você não preencheu o mínimo de caracteres do campo ',
  notConfirmed: 'Values could not be confirmed',
  badDomain: 'Incorrect domain value',
  badUrl: 'The answer you gave was not a correct URL',
  badCustomVal: 'You gave an incorrect answer',
  badInt: 'The answer you gave was not a correct number',
  badSecurityNumber: 'Your social security number was incorrect',
  badUKVatAnswer: 'Incorrect UK VAT Number',
  badStrength: 'The password isn\'t strong enough',
  badNumberOfSelectedOptionsStart: 'You have to choose at least ',
  badNumberOfSelectedOptionsEnd: ' answers',
  badAlphaNumeric: 'The answer you gave must contain only alphanumeric characters ',
  badAlphaNumericExtra: ' and ',
  wrongFileSize: 'The file you are trying to upload is too large',
  wrongFileType: 'The file you are trying to upload is of wrong type',
  groupCheckedTooFewStart: 'Please choose at least ',
  groupCheckedTooManyStart: 'Please choose a maximum of ',
  groupCheckedRangeStart: 'Please choose between ',
  groupCheckedEnd: ' item(s)',
  badDataVigencia: 'A data da vigência não pode ser menor que a data de assinatura',
  existsNumContrato: 'O número de contrato informado já existe',
  existsUsuario: 'O e-mail informado já existe',
  dataAssContratoBiggerAssTermo: 'A data de assinatura do termo aditivo não pode ser menor que a data do contrato'
};

/*** Configurações iniciais ***/
$(function() {
        
  /*** Seta data atual nos calendários ***/
  $("input.datepicker").datepicker({
    dateFormat     : "dd/mm/yy",
    gotoCurrent    : true,
    changeMonth    : true,
    changeYear     : true,
    dayNames       : ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
    dayNamesMin    : ['D','S','T','Q','Q','S','S','D'],
    dayNamesShort  : ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
    monthNames     : ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
    onSelect : function (date, datepicker) {
      if(date) {
        if(!($('#'+this.id).parent().hasClass('is-dirty'))) {
          $('#'+this.id).parent().addClass('is-dirty');
        }
      }
    }
  });

  /*** Máscara de data ***/
  $("input.datepicker").mask("00/00/0099");
  
  /*** Máscara de data ***/
  $("input.hora").mask("00:99");

  /*** Máscara de quantidade de iten ***/
  $('input.quantidade').mask('990');

  /*** Máscara de idade ***/
  $('input.idade').mask('90');

  /*** Máscara de id da proposta ***/
  $('input#numero_proposta').mask('9999999999999');

  var foneMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
  };
  var foneMaskOptions = {
    onKeyPress: function(val, e, field, options) {
      field.mask(foneMaskBehavior.apply({}, arguments), options);
    }
  };
  $("input.fone").mask(foneMaskBehavior, foneMaskOptions);
   
  $("input.cep").mask("00.000-000");
  $("input.cpf").mask("000.000.000-00");
  $("input.cpf").on('blur', function (e) {

    var elementoJquery = $('#'+this.id);
        elementoJquery.removeClass('error-field');

    if(!validateCPF(this.value, elementoJquery)) {
      elementoJquery.addClass('error-field');
    }
  });
    
  /*** Máscara monetária ***/
  $('input.valor').mask('#.##0,00', {reverse: true, maxlength: false});
    
  /*** Esconde div de erro (barra vermelha) após a vizualização ***/
  if($('#message').children("#error").text() != ""){
        
    $('#message').children("#success").removeClass("success");
    $('#message').children("#error").removeClass("error");
    $('#message').children("#error").addClass("error");
    $('#message').children("#error").fadeIn(600);

    if(!$('#message').children("#error").hasClass('error-template')) {

      setTimeout(function(){
        $('#message').children("#error").fadeOut(600);
      },10000);
    }
  }

    
  /*** Esconde div de successo (barra vede) após a vizualização ***/
  if($('#message').children("#success").text() != ""){
        
    $('#message').children("#error").removeClass("error");
    $('#message').children("#success").removeClass("success");
    $('#message').children("#success").addClass("success");
    $('#message').children("#success").fadeIn(600);
        
    setTimeout(function(){
      $('#message').children("#success").fadeOut(600);
    },10000);
  }
    
    
  /*** Isto implement a ajuda nos botoes ***/
  $('a.hint-helper').on('mouseover', function(event){

    $(this).find('span').text($(this).attr('hint-helper'));
    $(this).find('span').show();
  });
  $('a.hint-helper').on('mouseout', function(event){
    $(this).find('span').hide();
  });
});

/*** Função para validar CPF ***/
function validateCPF(strCPF, node){
        
  strCPF   = strCPF.replace(/[^\d]+/g,'');
  var Soma = 0;
  var Resto;
    
  var cpfWithMask = strCPF.replace(/([\d]{3,9})([\d]{2,9})/, "$1-$2");
      cpfWithMask = cpfWithMask.replace(/([\d]{3,3})/, "$1"+"\.");
      cpfWithMask = cpfWithMask.replace(/.([\d]{3})/, "\."+"$1"+"\.");
    
  node.val(cpfWithMask);

  if (strCPF == "00000000000") return false;

  for (i=1; i<=9; i++)
    Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);

  Resto = (Soma * 10) % 11;

  if ((Resto == 10) || (Resto == 11))
    Resto = 0;

  if (Resto != parseInt(strCPF.substring(9, 10)))
    return false;

  Soma = 0;
  for (i = 1; i <= 10; i++)
    Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);

  Resto = (Soma * 10) % 11;

  if ((Resto == 10) || (Resto == 11))
    Resto = 0;

  if (Resto != parseInt(strCPF.substring(10, 11)))
    return false;

  return true;
}

/*** Função para validar CNPJ ***/
function validateCNPJ(cnpj, node){

  cnpj = cnpj.replace(/[^\d]+/g,'');
    
  var cnpjWithMask = cnpj.replace(/([\d]{3,8})([\d]{2,8})/, "$1/$2");
      cnpjWithMask = cnpjWithMask.replace(/([\d]{2})/, "$1"+"\.");
      cnpjWithMask = cnpjWithMask.replace(/\.([\d]{3})/, "\."+"$1"+"\.");
      cnpjWithMask = cnpjWithMask.replace(/\/([\d]{4})/, "/"+"$1"+"-");
    
  node.val(cnpjWithMask);

  if(cnpj == '') return false;

  if (cnpj.length != 14)
    return false;

  // Elimina CNPJs invalidos conhecidos
  if (cnpj == "00000000000000" || 
    cnpj == "11111111111111" || 
    cnpj == "22222222222222" || 
    cnpj == "33333333333333" || 
    cnpj == "44444444444444" || 
    cnpj == "55555555555555" || 
    cnpj == "66666666666666" || 
    cnpj == "77777777777777" || 
    cnpj == "88888888888888" || 
    cnpj == "99999999999999")
  {
    return false;
  }

  // Valida DVs
  var tamanho = cnpj.length - 2
  var numeros = cnpj.substring(0,tamanho);
  var digitos = cnpj.substring(tamanho);
  var soma    = 0;
  var pos     = tamanho - 7;

  for (i = tamanho; i >= 1; i--) {
    soma += numeros.charAt(tamanho - i) * pos--;
    if (pos < 2)
      pos = 9;
  }

  resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

  if (resultado != digitos.charAt(0))
    return false;

  tamanho = tamanho + 1;
  numeros = cnpj.substring(0,tamanho);
  soma = 0;
  pos = tamanho - 7;

  for (i = tamanho; i >= 1; i--) {
    soma += numeros.charAt(tamanho - i) * pos--;
    if (pos < 2)
      pos = 9;
  }

  resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

  if (resultado != digitos.charAt(1))
    return false;

  return true;
}

String.prototype.urlDecode = function() {

  var str = this.replace(/\+/g," ");
      str = decodeURIComponent(str);
  return str;
}

String.prototype.extenso = function(c){
  var ex = [
    ["zero", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove", "dez", "onze", "doze", "treze",
     "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove"],
    ["dez", "vinte", "trinta", "quarenta", "cinqüenta", "sessenta", "setenta", "oitenta", "noventa"],
    ["cem", "cento", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"],
    ["mil", "milhão", "bilhão", "trilhão", "quadrilhão", "quintilhão", "sextilhão", "setilhão", "octilhão", "nonilhão",
     "decilhão", "undecilhão", "dodecilhão", "tredecilhão", "quatrodecilhão", "quindecilhão", "sedecilhão",
     "septendecilhão", "octencilhão", "nonencilhão"]
  ];
  var a, n, v, i, n = this.replace(c ? /[^,\d]/g : /\D/g, "").split(","), e = " e ", $ = "real", d = "centavo", sl;
  for(var f = n.length - 1, l, j = -1, r = [], s = [], t = ""; ++j <= f; s = []){
    j && (n[j] = (("." + n[j]) * 1).toFixed(2).slice(2));
    if(!(a = (v = n[j]).slice((l = v.length) % 3).match(/\d{3}/g), v = l % 3 ? [v.slice(0, l % 3)] : [], v = a ? v.concat(a) : v).length) continue;
    for(a = -1, l = v.length; ++a < l; t = ""){
      if(!(i = v[a] * 1)) continue;
      i % 100 < 20 && (t += ex[0][i % 100]) ||
      i % 100 + 1 && (t += ex[1][(i % 100 / 10 >> 0) - 1] + (i % 10 ? e + ex[0][i % 10] : ""));
      s.push((i < 100 ? t : !(i % 100) ? ex[2][i == 100 ? 0 : i / 100 >> 0] : (ex[2][i / 100 >> 0] + e + t)) +
      ((t = l - a - 2) > -1 ? " " + (i > 1 && t > 0 ? ex[3][t].replace("ão", "ões") : ex[3][t]) : ""));
    }
    a = ((sl = s.length) > 1 ? (a = s.pop(), s.join(" ") + e + a) : s.join("") || ((!j && (n[j + 1] * 1 > 0) || r.length) ? "" : ex[0][0]));
    a && r.push(a + (c ? (" " + (v.join("") * 1 > 1 ? j ? d + "s" : (/0{6,}$/.test(n[0]) ? "de " : "") + $.replace("l", "is") : j ? d : $)) : ""));
  }
  return r.join(e);
}

// procura um valor em um array
function in_array(array,valor){
  for(var ix=0; ix<array.length; ix++){
    if(array[ix] == valor){
      return true;
    }
  }
  return false;
}

/**
 * http://kevin.vanzonneveld.net
 * original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
 * improved by: Legaev Andrey
 * improved by: Michael White (http://getsprink.com)
 * @exemple
 *   example 1: is_object('23');
 *   returns 1: false
 *   example 2: is_object({foo: 'bar'});
 *   returns 2: true
 *   example 3: is_object(null);
 *   returns 3: false
 * @param oObject
 * @returns {Boolean}
 */
function isObject (oObject) {

  if (Object.prototype.toString.call(oObject) === '[object Array]') {
    return false;
  };
  return oObject !== null && typeof oObject === 'object';
};


/**
 * Mescla os atributos do objeto passado por parametro nos de origem
 * Caso o atributo passado não exista ele cria.
 *
 * @author  Rafael Nery - <rafael.nery@dbseller.com.br>
 * @example
 *   var oElemento = {
 *     "sId"    : "Testes",
 *     "sValor" : "Valor de Teste"
 *   }
 *
 *   oElemento.mergeObject(oElemento,  {"sValor" : "Modificicacao", "atributo" : "Adicional"} );
 *   //{ "sId" : "Testes", "sValor": "Modificicacao", "atributo" : "Adicional"}
 */
function mergeObject(oTarget, oObject) {

  for (var sPropriedade in oObject) {

    try {

      if ( oObject[sPropriedade].constructor == Object ) {
        oTarget[sPropriedade] = mergeObject(oTarget[sPropriedade], oObject[sPropriedade]);
      } else {
        oTarget[sPropriedade] = oObject[sPropriedade];
      }

    } catch(e) {
      oTarget[sPropriedade] = oObject[sPropriedade];
    }
  }

  return oTarget;
}

function atualizar() {
  location.reload();
}

var formToJSON = function(elements) {
  return [].reduce.call(elements, function(data, element) {
    data[element.name] = element.value;

    if(element.type) {

      if(element.type == 'checkbox') {
        data[element.name] = element.checked;
      }

      if(element.type == 'radio') {
        data[element.name] = element.form.elements[element.name].value;
      }
    }

    return data;
  }, {});
};

function exibirLinhasSelecionadas(listaSelecionados) { 

  var qtdeLinhasSelecionadas = listaSelecionados.get().length;

  if(qtdeLinhasSelecionadas == 0) {
  
    $("#title").show();
    $("#selectedLines").hide();
    $("span.table-header-buttons").hide();
  }
  
  if(qtdeLinhasSelecionadas > 0) {
    
    var textoItensSelecionados = qtdeLinhasSelecionadas+' itens selecionados';
    if(qtdeLinhasSelecionadas == 1) {
      textoItensSelecionados = qtdeLinhasSelecionadas+' item selecionado';
    }

    $("#title").hide();
    $("#selectedLines").show();
    $("#selectedLines").html(textoItensSelecionados);
    $("span.table-header-buttons").show();
  }
}
