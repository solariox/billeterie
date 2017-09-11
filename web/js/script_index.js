var numberOfTick = 0;
// Pour changer le contenu du message de tarif réduit 
function handleChange(cb) {
  if (cb.checked == true) {
    numberOfTick += 1;

  } else {
    numberOfTick -= 1;
  }
  $(".reduced_message").css('display', numberOfTick === 0 ? 'none' : 'inherit');
}


$(document).ready(function () {
  var reg = /fr/;
  var CheminComplet = document.location.href;
  if (reg.test(CheminComplet)) {
    $(' </div><a href="#" id="add_ticket" class="btn btn-default"> Ajouter un ticket</a></div> <br/>').insertAfter('#oc_ticketingbundle_commande_tickets');
  } else {
    $('  </div><a href="#" id="add_ticket" class="btn btn-default"> Add a ticket</a></div><br/>').insertAfter('#oc_ticketingbundle_commande_tickets');
  }


  // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
  var $container = $('div#oc_ticketingbundle_commande_tickets');

  // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
  var index = $container.find(':input').length;

  // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
  $('#add_ticket').click(function (e) {
    addTicket($container);

    e.preventDefault(); // évite qu'un # apparaisse dans l'URL
    return false;
  });

  // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
  if (index == 0) {
    addTicket($container);
  } else {
    // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
    $container.children('div').each(function () {
      addDeleteLink($(this));
    });


  }

  function DisableDay(date) {
    var day = date.getDay();
    var dayNmbr = date.getDate();
    var month = date.getMonth() + 1;

    // If day == 1 then it is MOnday, 2 == tuesday, etc... 
    if (day == 2 || day == 0) {
      return [false];
    } else if (month == 5 && dayNmbr == 1) { //Premier mai
      return [false];
    } else if (month == 11 && dayNmbr == 1) { //Premier novembre
      return [false];
    } else if (month == 12 && dayNmbr == 25) { // 25 décembre 
      return [false];
    } else {
      return [true];
    }
  }


  // La fonction qui ajoute un formulaire TypeType
  function addTicket($container) {
    // Dans le contenu de l'attribut « data-prototype », on remplace :
    // - le texte "__name__label__" qu'il contient par le label du champ
    // - le texte "__name__" qu'il contient par le numéro du champ
    var template = $container.attr('data-prototype')
      .replace(/__name__label__/g, 'Ticket n°' + (index + 1))
      .replace(/__name__/g, index);

    // On crée un objet jquery qui contient ce template
    var $prototype = $(template);

    // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
    addDeleteLink($prototype);

    // On ajoute le prototype modifié à la fin de la balise <div>
    $container.append($prototype);

    // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
    index++;

    $('.datepickerBirthday').datepicker({
      closeText: 'Fermer',
      prevText: 'Précédent',
      nextText: 'Suivant',
      currentText: 'Aujourd\'hui',
      monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
      monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
      dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
      dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
      dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
      weekHeader: 'Sem.',
      dateFormat: 'dd-mm-yy',

      changeYear: true,
      yearRange: '1900:' + new Date().getFullYear(),
      maxDate: '0',
    });

    $('.datepickerBookdate').datepicker({
      closeText: 'Fermer',
      prevText: 'Précédent',
      nextText: 'Suivant',
      currentText: 'Aujourd\'hui',
      monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
      monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
      dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
      dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
      dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
      weekHeader: 'Sem.',
      dateFormat: 'dd-mm-yy',

      changeYear: true,
      yearRange: new Date().getFullYear() + ':2100',
      minDate: '0',
      beforeShowDay: DisableDay,
      onSelect: function (date, instance) {
        if (date == $(this).attr('data_today') && $('.halfdayCheckbox').attr('data_itsHalfday')) {
          $('.halfdayCheckbox').prop('checked', true).prop('disabled', true);

        } else {
          $('.halfdayCheckbox').prop('checked', false).prop('disabled', false);
        }
      }


    });

  }

  // La fonction qui ajoute un lien de suppression d'une catégorie
  function addDeleteLink($prototype) {
    // Création du lien
    var reg = /fr/;
    var CheminComplet = document.location.href;
    if (reg.test(CheminComplet)) {
      var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');
    } else {
      var $deleteLink = $('<a href="#" class="btn btn-danger">Delet</a>');
    }

    // Ajout du lien
    $prototype.append($deleteLink);

    // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
    $deleteLink.click(function (e) {
      $prototype.remove();

      e.preventDefault(); // évite qu'un # apparaisse dans l'URL
      return false;
    });
  }
});