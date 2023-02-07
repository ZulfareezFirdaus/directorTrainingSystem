
$(document).ready(function(data){
    $('#submitTraining').click(function() {
        
        var dateProgramStart = $('#StartDate_trainingProgram').val() ;
        var dateProgramEnd = $('#EndDate_trainingProgram').val() ;
        var nameProgram = $('#Name_trainingProgram').val() ;
        var nameOrganiser = $('.Name_organiser').val() ;
        var nameDirector = $('.Name_director').val() ;
        var countDirector = $('.Count_director').val() ;
        var countOrganiser = $('.Count_organiser').val() ;
        var status = "trainingProgram";
        
        if(dateProgramEnd == ''){
            var dateProgramEnd = $('#StartDate_trainingProgram').val() ;
        }
        
       if(countDirector > 0){
           if(nameDirector == 'InputText'){
                var nameDirector = $('.Name_SelectDirector').val() ;
                var popNameDirector = 'Exist';
           }
           else{
               var nameDirector = $('.Name_director').val() ;
               var popNameDirector = '';
           }   
       }
        else{
            var popNameDirector = 'Exist';
            var nameDirector = $('.Name_director').val() ;
        }
        
        if(countOrganiser > 0){
           if(nameOrganiser == 'InputText'){
                var nameOrganiser = $('.Name_SelectOrganiser').val() ;
                var popNameOrganiser = 'Exist';
           }
           else{
               var nameOrganiser = $('.Name_organiser').val() ;
               var popNameOrganiser = '';
           }
        }
        else{
            var popNameOrganiser = 'Exist';
            var nameOrganiser = $('.Name_organiser').val() ;
        }
        
        if(nameDirector == ""){
           alert("Director name cannot be empty!");
           $(".Name_director").css("border", "1px solid red");
           setTimeout(function() {
               $(".Name_director").css("border", "1px solid #eaeaea"); 
           }, 5000);
        }
        if(nameProgram == ""){
           alert("Name training/program cannot be empty!");
            $(".Name_trainingProgram").css("border", "1px solid red"); 
            setTimeout(function() {
               $(".Name_trainingProgram").css("border", "1px solid #eaeaea"); 
           }, 5000);
        }
        if(nameOrganiser == ""){
           alert("Organiser cannot be empty!");
           $(".Name_organiser").css("border", "1px solid red");
           setTimeout(function() {
               $(".Name_organiser").css("border", "1px solid #eaeaea"); 
           }, 5000);
        }
        if(dateProgramStart == ""){
           alert("Date training/program cannot be empty!");
           $(".Date_trainingProgram").css("border", "1px solid red");     
           setTimeout(function() {
               $(".Date_trainingProgram").css("border", "1px solid #eaeaea"); 
           }, 5000);
        }
        
        if(dateProgramStart != '' && nameProgram != '' && nameOrganiser != '' && nameDirector != '' ) {
            if (confirm('Please check the details before submit! \n\nDirector Name : ' + nameDirector + '\n\nTraining or Program Attended : ' + nameProgram + '\n\nOrganiser/Speaker : ' + nameOrganiser + '\n\nStart Date Program/Training : ' + dateProgramStart + '\n\nEnd Date Program/Training : ' + dateProgramEnd)) {
                $.ajax({  
                    url:"./system/process.php",  
                    method:"POST",  
                    dataType: "json",
                    data:{status:status,dateProgramStart:dateProgramStart,nameOrganiser:nameOrganiser,nameProgram:nameProgram,nameDirector:nameDirector,popNameDirector:popNameDirector,popNameOrganiser:popNameOrganiser,dateProgramEnd:dateProgramEnd},  
                    success:function(data){ 
                        if ($.trim(data) === "Success") {
                            $("#modalInsert").modal('hide');
                            $("#refreshTable").load("refreshTable.php");
                            $("#SelectDirector").load("refreshDirectorList.php");
                            $("#SelectOrganiser").load("refreshOrganiserList.php");
                            $("#CountIndicator").load("refreshCountIndicator.php");
                            $("#tableTrainingList").load("refreshTableTraining.php");
                            $("#myform")[0].reset();
                            Swal.fire(
                              'Success',
                              'Data Inserted Successfully!',
                              'success'
                            );
                        }
                        else if ($.trim(data) === "Failed") {
                            Swal.fire(
                              'Error',
                              'Please try again later!',
                              'error'
                            );
                        }
                    }  
               });
            }
       }
    });
    
    $('#submitBoard').click(function() {
        var nameDirector = $('.Name_director').val() ;
        var status = "addDirector";
        
        if(nameDirector == ""){
           alert("Director name cannot be empty!");
           $(".Name_director").css("border", "1px solid red");
           setTimeout(function() {
               $(".Name_director").css("border", "1px solid #eaeaea"); 
           }, 5000);
        }
        
        if(nameDirector != '' ) {
            if (confirm('Please check the details before submit! \n\nDirector Name : ' + nameDirector)) {
                $.ajax({  
                    url:"./system/process.php",  
                    method:"POST",  
                    dataType: "json",
                    data:{status:status,nameDirector:nameDirector},  
                    success:function(data){ 
                        if ($.trim(data) === "Success") {
                            $("#modalInsert").modal('hide');
                            $("#TableDirector").load("refreshTableDirector.php");
                            $("#myform")[0].reset();
                            Swal.fire(
                              'Success',
                              'Data Inserted Successfully!',
                              'success'
                            );
                        }
                        else if ($.trim(data) === "Failed") {
                            Swal.fire(
                              'Error',
                              'Please try again later!',
                              'error'
                            );
                        }
                    }  
               });
            }
       }
    });
    
    $('.updateDataDirector').click(function(e) {
        e.preventDefault();
        var nameDirector = $('#Name_director').val() ;
        var idDirector = $('#ID_director').val() ;
        var status = "updateDataDirector";
        
        if(nameDirector == ""){
           alert("Director name cannot be empty!");
           $(".Name_director").css("border", "1px solid red");
           setTimeout(function() {
               $(".Name_director").css("border", "1px solid #eaeaea"); 
           }, 5000);
        }
        
        if(nameDirector != '' ) {
            if (confirm('Please check the details before submit! \n\nDirector Name : ' + nameDirector)) {
                $.ajax({  
                    url:"./system/process.php",  
                    method:"POST",  
                    dataType: "json",
                    data:{status:status,nameDirector:nameDirector,idDirector:idDirector},  
                    success:function(data){ 
                        if ($.trim(data) === "Success") {
                            $("#modalUpdate").modal('hide');
                            $("#TableDirector").load("refreshTableDirector.php");
                            $("#myform")[0].reset();
                            Swal.fire(
                              'Success',
                              'Data Updated Successfully!',
                              'success'
                            );
                        }
                        else if ($.trim(data) === "Failed") {
                            Swal.fire(
                              'Error',
                              'Please try again later!',
                              'error'
                            );
                        }
                    }  
               });
            }
       }
    });
    
    $('.updateDirector').click(function(e) {
        e.preventDefault();
        var idDirector = $(this).attr("id");
        var status = "updateDirector";

        $.ajax({  
            url:"./system/process.php",  
            method:"POST",  
            dataType: "json",
            data:{status:status,idDirector:idDirector},  
            success:function(data){ 
                $("#modalUpdate").modal('show');
                $('#updateDirector').html(data);
            }  
       });
    });
    
    $('#printDiv').click(function() {
        $("#printThis").print();
        $('#printThis').css('display', 'block');
    });
    
    $('#SelectDirector').on('change', function(){
        var demovalue = $(this).val(); 

        if(demovalue == "InputText"){
            $("#SelectDirectorInput").show();
        }
        else{
            $("#SelectDirectorInput").hide();
        }
    });
    
    $('#SelectOrganiser').on('change', function(){
        var demovalue = $(this).val(); 

        if(demovalue == "InputText"){
            $("#SelectOrganiserInput").show();
        }
        else{
            $("#SelectOrganiserInput").hide();
        }
    });

});

