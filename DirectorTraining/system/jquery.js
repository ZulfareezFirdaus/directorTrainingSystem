
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
        
        if(dateProgramStart > dateProgramEnd){
           alert("Start Date training/program cannot be more than End Date! ");
           $(".EndDate_trainingProgram").css("border", "1px solid red");     
           setTimeout(function() {
               $(".EndDate_trainingProgram").css("border", "1px solid #eaeaea"); 
           }, 5000);
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
           $(".StartDate_trainingProgram").css("border", "1px solid red");     
           setTimeout(function() {
               $(".StartDate_trainingProgram").css("border", "1px solid #eaeaea"); 
           }, 5000);
        }
        
        if(dateProgramStart != '' && nameProgram != '' && nameOrganiser != '' && nameDirector != '' && dateProgramStart <= dateProgramEnd ) {
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
    
    $('#updateDataDirector').click(function(e) {
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
    
    $('.updateTraining').click(function(e) {
        e.preventDefault();
        var idTrainingProgram = $(this).attr("id");
        var status = "updateTraining";

        $.ajax({  
            url:"./system/process.php",  
            method:"POST",  
            dataType: "json",
            data:{status:status,idTrainingProgram:idTrainingProgram},  
            success:function(data){ 
                $("#modalUpdate").modal('show');
                $('#updateTraining').html(data);
            }  
       });
    });
    
    $('#updateDataTraining').click(function() {

        var nameDirector = $('#Name_director').val() ;
        var idTrainingProgram = $('#ID_trainingProgram').val() ;
        var idDirector = $('#ID_director').val() ;
        var idOrganiser = $('#ID_organiser').val() ;
        var dateProgramStart = $('#InputStartDate_trainingProgram').val() ;
        var dateProgramEnd = $('#InputEndDate_trainingProgram').val() ;
        let nameProgram = $('#textAreaName_trainingProgram').val() ;
        var nameOrganiser = $('#Name_organiser').val() ;
        
        var status = "updateDataTraining";
        
        if(dateProgramStart > dateProgramEnd){
           alert("Start Date training/program cannot be more than End Date! ");
           $(".InputEndDate_trainingProgram").css("border", "1px solid red");     
           setTimeout(function() {
               $(".InputEndDate_trainingProgram").css("border", "1px solid #eaeaea"); 
           }, 5000);
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
           alert("Start Date training/program cannot be empty!");
           $(".StartDate_trainingProgram").css("border", "1px solid red");     
           setTimeout(function() {
               $(".StartDate_trainingProgram").css("border", "1px solid #eaeaea"); 
           }, 5000);
        }
        
        if(dateProgramEnd == ""){
           alert("End Date training/program cannot be empty!");
           $(".EndDate_trainingProgram").css("border", "1px solid red");     
           setTimeout(function() {
               $(".EndDate_trainingProgram").css("border", "1px solid #eaeaea"); 
           }, 5000);
        }
        
        if(dateProgramEnd != '' && dateProgramStart != '' && nameProgram != '' && nameOrganiser != '' && nameDirector != '' && dateProgramStart <= dateProgramEnd ) {
            if (confirm('Please check the details before submit! \n\nDirector Name : ' + nameDirector + '\n\nTraining or Program Attended : ' + nameProgram + '\n\nOrganiser/Speaker : ' + nameOrganiser + '\n\nStart Date Program/Training : ' + dateProgramStart + '\n\nEnd Date Program/Training : ' + dateProgramEnd)) {
                $.ajax({  
                    url:"./system/process.php",  
                    method:"POST",  
                    dataType: "json",
                    data:{idOrganiser:idOrganiser,idDirector:idDirector,idTrainingProgram:idTrainingProgram,status:status,dateProgramStart:dateProgramStart,nameOrganiser:nameOrganiser,nameProgram:nameProgram,nameDirector:nameDirector,dateProgramEnd:dateProgramEnd},  
                    success:function(data){ 
                        if ($.trim(data) === "Success") {
                            $("#modalUpdate").modal('hide');
                            $("#tableTrainingList").load("refreshTableTraining.php");
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
    
    $('.deleteTraining').click(function(e) {
        e.preventDefault();
        var idTrainingProgramDelete = $(this).attr("id");
        
        var status = "deleteTraining";
        
        if (confirm('Are you sure want to permanently delete this ? ' )) {
            $.ajax({  
                url:"./system/process.php",  
                method:"POST",  
                dataType: "json",
                data:{status:status,idTrainingProgramDelete:idTrainingProgramDelete},  
                success:function(data){ 
                    if ($.trim(data) === "Success") {
                        $("#tableTrainingList").load("refreshTableTraining.php");
                        Swal.fire(
                          'Success',
                          '1 Row Deleted Successfully!',
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
    });
    
    $('.Name_director').keyup(function() {
        validateName_director();
    });
    
    $('.Name_SelectDirector').keyup(function() {
        validateName_director();
    });
    
    function validateName_director() {
        
        if($("#Name_SelectDirector").val() != ""){
            var nameDirector = $("#Name_SelectDirector").val();
        }
        if($(".Name_director").val() != "" && $(".Name_director").val() != "InputText"){
            var nameDirector = $(".Name_director").val();
        }
        var status = "validateName_director"
        
        $.ajax({  
            url:"./system/process.php",  
            method:"POST",  
            dataType: "json",
            data:{nameDirector:nameDirector,status:status},  
            success:function(data){ 
                if ($.trim(data) === "Success") {
                    $("#alertValidateName_directorExist").show();
                    $("#submitBoard").prop('disabled', true);
                    $("#submitTraining").prop('disabled', true);
                }
                else if ($.trim(data) === "Failed") {
                    $("#alertValidateName_directorExist").hide();
                    $("#submitBoard").prop('disabled', false);
                    $("#submitTraining").prop('disabled', false);
                }
            }  
       });
    }
    
    $('.Name_organiser').keyup(function() {
        validateName_organiser();
    });
    
    $('#Name_SelectOrganiser').keyup(function() {
        validateName_organiser();
        
    });
    
    function validateName_organiser() {
        
        if($("#Name_SelectOrganiser").val() != ""){
            var nameOrganiser = $("#Name_SelectOrganiser").val();
        }
        if($(".Name_organiser").val() != "" && $(".Name_organiser").val() != "InputText"){
            var nameOrganiser = $(".Name_organiser").val();
        }
        var status = "validateName_organiser"
        
        $.ajax({  
            url:"./system/process.php",  
            method:"POST",  
            dataType: "json",
            data:{nameOrganiser:nameOrganiser,status:status},  
            success:function(data){ 
                if ($.trim(data) === "Success") {
                    $("#alertValidateName_organiserExist").show();
                    $("#submitTraining").prop('disabled', true);
                }
                else if ($.trim(data) === "Failed") {
                    $("#alertValidateName_organiserExist").hide();
                    $("#submitTraining").prop('disabled', false);
                }
            }  
       });
    }

});

