

  jQuery( function() {
  //  $( "#datepicker" ).datepicker();
   // $( "#datepicker" ).formatDate( "d MM, y" );
   // $( "#datepicker" ).datepicker( "option", "dateFormat", "d MM, y" );
   //$('input.timepicker').timepicker({});

   // Time Picker for Admin Event Page
   $('input.time_h').timepicker({
    timeFormat: 'H',
    interval: 60,
    step: 60,
    dynamic: true,
    dropdown: true,
    scrollbar: true
    });

    $('input.time_m').timepicker({
      timeFormat: 'i',
      step: 15,
      minTime: '11',
      maxTime: '11:45am',
      defaultTime: '11',
      startTime: '10:00',
      dynamic: false,
      dropdown: true,
      scrollbar: true
      });


    // Date Picket for Admin Event Page
    $("#_start_date").datepicker({
      dateFormat: "MM dd, yy",
      showOtherMonths: true,
      selectOtherMonths: true,

      
      onSelect: function () {
        var startDateDay = $.datepicker.formatDate("dd", $(this).datepicker('getDate'));
        var startDateMonth = $.datepicker.formatDate("mm", $(this).datepicker('getDate'));
        var startDateYear = $.datepicker.formatDate("yy", $(this).datepicker('getDate'));

      document.getElementById('_start_day').value = startDateDay;
      document.getElementById('_start_month').value = startDateMonth;
      document.getElementById('_start_year').value = startDateYear;
      $("#_end_date").datepicker( "option", "minDate", $(this).datepicker('getDate') )

      }
  },

  );

    $("#_end_date").datepicker({
      dateFormat: "MM dd, yy",
      showOtherMonths: true,
      selectOtherMonths: true,
      
      onSelect: function () {
        var endDateDay = $.datepicker.formatDate("dd", $(this).datepicker('getDate'));
        var endDateMonth = $.datepicker.formatDate("mm", $(this).datepicker('getDate'));
        var endDateYear = $.datepicker.formatDate("yy", $(this).datepicker('getDate'));


        //alert(date);
      // $("#month").value = selectedDate;

      document.getElementById('_end_day').value = endDateDay;
      document.getElementById('_end_month').value = endDateMonth;
      document.getElementById('_end_year').value = endDateYear;
      $("#_start_date").datepicker( "option", "maxDate", $(this).datepicker('getDate') )

      }
  },
  );


  } );
  