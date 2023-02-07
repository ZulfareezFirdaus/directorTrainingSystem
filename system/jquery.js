function doSomething(){
    swal({
       title: "Log Out",
       text: "Are you sure you want to log out ? ",
       type: "warning",
       showCancelButton: true,
       confirmButtonColor: "#EE4B2B",
       confirmButtonText: "Log Out",
       cancelButtonText: "Cancel",
       closeOnConfirm: false
    }, function (isConfirm) {
          if (isConfirm) {     
              window.location.href='../logout.php';   
          } 
    });
}

function doSomethingSpecial(){
    swal({
       title: "Log Out",
       text: "Are you sure you want to log out ? ",
       type: "warning",
       showCancelButton: true,
       confirmButtonColor: "#EE4B2B",
       confirmButtonText: "Log Out",
       cancelButtonText: "Cancel",
       closeOnConfirm: false
    }, function (isConfirm) {
          if (isConfirm) {     
              window.location.href='./logout.php';   
          } 
    });
}

$(document).ready(function(data){
    
 //untuk login
$('#btnLogin').click(function() {

    var status = "LoginSystem";
    var email = $("#val-email").val();
    var password = $("#val-password").val();

	if(email == "" || password == ""){
		$(".form-valide").valid();
    }
    if(email != "" && password != "" ){ 
        $.ajax({
          url: "system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            email : email,
            password : password
          },
          success: function(data) {
			  if ($.trim(data) === "SuccessNew") {
                $('.form-valide')[0].reset();
                window.location.href='changePassword.php';
			  }
              else if ($.trim(data) === "Success") {
                $('.form-valide')[0].reset();
                window.location.href='./dashboard.php';
			  }
			  else if ($.trim(data) === "Failed") {
				swal("Invalid!", "email or password is invalid!", "error");
                $("#val-password").val("");
			  }
                
          },
			error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
    
 //untuk set password baru jika still password default 'p@ssword1234'
$('#btnConfirmPassword').click(function() {
	
    var status = "ConfirmPassword";
    var password = $("#val-password").val();
    var passwordConfirmed = $("#val-passwordConfirmed").val();
	
	if(password == "" || passwordConfirmed == ""){
		$(".form-valide").valid();
	}
	
    if(password == passwordConfirmed && password != "" ){ 
        $.ajax({
          url: "system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            password : password
          },
          success: function(data) {
			  if ($.trim(data) === "Success") {
                $('.form-valide')[0].reset();
                    swal({
                       title: "Successfully!",
                       text: "Password is successfully changed!",
                       type: "success",
                       showCancelButton: false,
                       confirmButtonColor: "#3085d6",
                       confirmButtonText: "Done",
                       closeOnConfirm: false
                    }, function () {
                          window.location.href='./iPadManagementSystem/'; 
                    });
			  }
			  else if ($.trim(data) === "Failed") {
				swal("Invalid!", "email or password is invalid!", "error");
                $("#val-password").val("");
			  }
                
          },
			error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
$('#btnConfirmChangePassword').click(function() {
	
    var status = "CheckPassword";
    var password = $("#val-password").val();
    var CurrentPassword = $("#val-CurrentPassword").val();
    var passwordConfirmed = $("#val-passwordConfirmed").val();
    var usersEmail = $("#val-usersEmail").val();
	
	if(password == "" || passwordConfirmed == "" || CurrentPassword == ""){
		$(".form-valide").valid();
	}
	
    if(password == passwordConfirmed && password != "" ){ 
        $.ajax({
          url: "system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            password : password,
            CurrentPassword : CurrentPassword,
            usersEmail : usersEmail
          },
          success: function(data) {
			  if ($.trim(data) === "Success") {
                $('.form-valide')[0].reset();
                    swal({
                       title: "Successfully!",
                       text: "Password is successfully changed!",
                       type: "success",
                       showCancelButton: false,
                       confirmButtonColor: "#3085d6",
                       confirmButtonText: "Done",
                       closeOnConfirm: false
                    }, function () {
                          location.reload(true);  
                    });
			  }
			  else if ($.trim(data) === "Failed") {
				swal("Invalid!", "email or password is invalid!", "error");
                $("#val-password").val("");
			  }
              else if ($.trim(data) === "Wrong") {
				swal("Invalid!", "Current password is invalid!", "error");
                $("#val-password").val("");
                $("#val-passwordConfirmed").val("");
			  }
                
          },
			error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
$('#btnPreviewChangePassword').click(function() {
    var status = "previewInfoUpdatePassword";
    var CurrentPassword = $("#val-CurrentPassword").val();
    var password = $("#val-password").val();
	var passwordConfirmed = $("#val-passwordConfirmed").val();
    var usersID = $("#val-usersID").val();
    
    if(password == "" || passwordConfirmed == "" || CurrentPassword == ""){
		$(".form-valide").valid();
	}
	
    if(password == passwordConfirmed && password != "" ){ 
        $.ajax({
          url: "./system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            CurrentPassword : CurrentPassword,
            password : password,
            passwordConfirmed : passwordConfirmed,
            usersID : usersID
          },
          success: function(data) {
              $('#PasswordDetails').html(data);
              $("#basicModalPassword").modal('show');
          },
			error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
  });
    
// end untuk kegunaan login =================

//masukkan data user kedalam database
$('#btnSaveUser').click(function() {
    var status = "submitInfoUser";
    var usersName = $("#val-usersName").val();
	var usersEmail = $("#val-usersEmail").val();

    if(usersName != "" && usersEmail != "" ){ 
        $.ajax({
          url: "../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            usersEmail : usersEmail,
            usersName : usersName
          },
          success: function(data) {
			  if ($.trim(data) === "Success") {
                $("#basicModal").modal('hide');
                $('.form-valide')[0].reset();
                $('#load_todayIpadReg').load("../form/todayIpadRegTable.php").fadeIn("slow");
				swal("Successfully!", "Insert Record Successfully!", "success");
			  }
			  else if ($.trim(data) === "Failed") {
				swal("Error!", "Please check the internet connection!", "error");    
			  }
                
          },
			error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});

$('#btnSaveChangeUser').click(function() {
    var status = "submitInfoUpdateUser";
    var usersName = $("#val-usersName").val();
	var usersEmail = $("#val-usersEmail").val();
    var usersID = $("#val-usersID").val();

    if(usersName != "" && usersEmail != "" ){ 
        $.ajax({
          url: "./system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            usersEmail : usersEmail,
            usersName : usersName,
            usersID : usersID
          },
          success: function(data) {
			  if ($.trim(data) === "Success") {
                $("#basicModal").modal('hide');
				swal("Successfully!", "Update Record Successfully!", "success");
			  }
			  else if ($.trim(data) === "Failed") {
				swal("Error!", "Please check the internet connection!", "error");    
			  }
                
          },
			error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
//untuk masukkan data owner kedalam database
$('#saveOwner').click(function() {
    var status = "submitInfoOwner";
    var ownerName = $("#val-ownerName").val();
    var ownerDept = $("#val-ownerDept").val();
    var addDept = $("#val-addDept").val();

    if(ownerName != "" && ownerDept != "" ){ 
        $.ajax({
          url: "../../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            ownerName : ownerName,
            ownerDept : ownerDept,
            addDept : addDept
          },
          success: function(data) {
                if ($.trim(data) === "Success") {
                    $("#basicModal").modal('hide');
                    
                    swal({
                       title: "Successfully!",
                       text: "1 user record was successfully inserted!",
                       type: "success",
                       showCancelButton: true,
                       confirmButtonColor: "#3085d6",
                       confirmButtonText: "Assign iPad",
                       cancelButtonText: "Done",
                       closeOnConfirm: false
                    }, function (isConfirm) {
                          if (isConfirm) {     
                              window.location.href='assignIpad.php';   
                          } 
                          else {     
                              location.reload(true);   
                          }
                    });
                    
                    $("#myDivDept").hide();
                    $('.form-valide')[0].reset();
                }
                else if ($.trim(data) === "Failed") {
                    swal("Error!", "Please check the internet connection!", "error");    
                }
               
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
//untuk masukkan data owner kedalam database
$('#updateOwner').click(function() {
    var status = "submitUpdateInfoOwner";
    var ownerName = $("#val-ownerName").val();
    var ownerDept = $("#val-ownerDept").val();
    var addDept = $("#val-addDept").val();
    var IDowner = $("#IDowner").val();

    if(ownerName != "" && ownerDept != "" ){ 
        $.ajax({
          url: "../../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            ownerName : ownerName,
            ownerDept : ownerDept,
            addDept : addDept,
            IDowner:IDowner
          },
          success: function(data) {
                if ($.trim(data) === "Success") {
                    $("#basicModal").modal('hide');
                    
                    swal({
                       title: "Successfully!",
                       text: "Update Record Successfully!",
                       type: "success",
                       showCancelButton: false,
                       confirmButtonColor: "#3085d6",
                       confirmButtonText: "Done",
                       cancelButtonText: "Done",
                       closeOnConfirm: false
                    }, function (isConfirm) {
                          if (isConfirm) {     
                              window.location.href='../data/owner/listOwner.php?status=AllOwner';   
                          } 
                          else {     
                              location.reload(true);     
                          }
                    });
                    
                    $("#myDivDept").hide();
                    $('.form-valide')[0].reset();
                }
                else if ($.trim(data) === "Failed") {
                    swal("Error!", "Please check the internet connection!", "error");    
                }
               
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
//untuk masukkan data department kedalam database
$('#saveDept').click(function() {
    var status = "submitInfoDept";
    var ownerDept = $("#val-ownerDept").val();

    if(ownerDept != "" ){ 
        $.ajax({
          url: "../../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            ownerDept : ownerDept
          },
          success: function(data) {
                if ($.trim(data) === "Success") {
                    $("#basicModal").modal('hide');
                    
                    swal({
                       title: "Successfully!",
                       text: "1 department record was successfully inserted!",
                       type: "success",
                       showCancelButton: false,
                       confirmButtonColor: "#3085d6",
                       confirmButtonText: "Done",
                       closeOnConfirm: false
                    }, function () {
                          location.reload(true); 
                    });
                    
                    $("#myDivDept").hide();
                    $('.form-valide')[0].reset();
                }
                else if ($.trim(data) === "Failed") {
                    swal("Error!", "Please check the internet connection!", "error");    
                }
               
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
//untuk masukkan data department kedalam database
$('#UpdateDept').click(function() {
    var status = "submitUpdateInfoDept";
    var ownerDept = $("#val-ownerDept").val();
    var IDdept = $("#IDdept").val();

    if(ownerDept != "" ){ 
        $.ajax({
          url: "../../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            ownerDept : ownerDept,
            IDdept : IDdept
          },
          success: function(data) {
                if ($.trim(data) === "Success") {
                    $("#basicModal").modal('hide');
                    
                    swal({
                       title: "Successfully!",
                       text: "Update Record Successfully!",
                       type: "success",
                       showCancelButton: false,
                       confirmButtonColor: "#3085d6",
                       confirmButtonText: "Done",
                       closeOnConfirm: false
                    }, function () {
                          window.location.href='../data/dept/listDept.php'; 
                    });
                    
                    $("#myDivDept").hide();
                    $('.form-valide')[0].reset();
                }
                else if ($.trim(data) === "Failed") {
                    swal("Error!", "Please check the internet connection!", "error");    
                }
               
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
//untuk review data ipad sebelum hantar ke database
 $('#btnNextNewiPad').click(function() {
    var status = "btnNextNewiPad";
     
    if($(".val-assetTypeSelect").val() == 'InputText'){
        var assetType = $(".val-assetType2").val();
    }
    else{
        var assetType = $(".val-assetTypeSelect").val();
    }
     
    if($(".val-assetTypeSelect").val() == undefined){
        var assetType = $(".val-assetType").val();
    }
     
    if($(".val-modelTypeSelect").val() == 'InputText'){
        var modelType = $(".val-modelType2").val();
    }
    else{
        var modelType = $(".val-modelTypeSelect").val();
    }
     
    if($(".val-modelTypeSelect").val() == undefined){
        var modelType = $(".val-modelType").val();
    }
     
    if($("#val-dateregistered").val() != ""){
        var dateregistered = $("#val-dateregistered").val();
    }
     else{
         var dateregistered = "";
     }

    var rfidno = $("#val-rfidNo").val();
    var sirino = $("#val-siriNo").val();
    var remarks = $("#val-remarks").val();
    var box = $("input[name='val-box']:checked").val();
    var adapter = $("input[name='val-adapter']:checked").val();
    var cable = $("input[name='val-cable']:checked").val();
    var accesories = $("input[name='val-accesories']:checked").val();
    var valueSelect = $("#val-otherAccessoriesSelect").val();
    var detailAccessoriess = $("#val-detailAccessories2").val();
    var detailAccessoriesss = $("#val-detailAccessories3").val();

    if(modelType == "" || assetType == "" || rfidno == "" || sirino == "" || box == undefined || 
       adapter == undefined || cable == undefined || accesories == undefined)
    {
       $(".form-valide").valid();
    }
     
    if($('#InputText').is(':checked')) {
        var InputText = 'Check';
    }
     
    //if checkbox is click  
    if(accesories == '1' && InputText == 'Check' && detailAccessoriess == ""){
       $("#val-accessories-error").show();
        $("#val-accessories-error-2").hide();
        var errorCheckbox = '1';
        var errorSelect = '0';

    }
     
    //if checkbox is not click
    if(accesories == '1' && InputText != 'Check' && valueSelect == ""){
       $("#val-accessories-error-2").show();
        var errorSelect = '1';
        var errorCheckbox = '0'; 
    }
     else if(accesories == '1' && InputText != 'Check' && valueSelect != ""){
         $("#val-accessories-error-2").hide();
         var errorSelect = '0';
        var errorCheckbox = '0';
     }
     
    if($(".val-assetType").val() == ""){
       $("#val-assetType-error").show();
    }
     
    if($(".val-modelType").val() == ""){
       $("#val-modelType-error").show();
    }
     
    if(accesories == '1' && valueSelect != ""){
        detailAccessories = valueSelect;
    }
     
    if(accesories == '1' && detailAccessoriess != ""){
        detailAccessories = detailAccessoriess;
    }
     
    if(accesories == '1' && detailAccessoriesss != undefined){
        detailAccessories = detailAccessoriesss;
    }
     
     
    if(modelType != "" && assetType != "" && rfidno != "" && sirino != "" && box != undefined && 
       adapter != undefined && cable != undefined && accesories != undefined && errorCheckbox != '1' && errorSelect != '1')
    {
        if(accesories == '1' && detailAccessories != "")
        { 
          
            $.ajax({
              url: "../../system/process.php",
              method: "POST",
              dataType: "json",
              data: {
               status: status,
                assetType : assetType,
                modelType : modelType,
                rfidno : rfidno,
                sirino : sirino,
                remarks : remarks,
                box : box,
                adapter : adapter,
                cable : cable,
                accesories : accesories,
                detailAccessories : detailAccessories 
              },
              success: function(data) {
                  
                  $('#ipadDetails').html(data);
                  $("#basicModal").modal('show');
                  $("#emptyAlert").hide();
                  $("#val-accessories-error").hide();
              },
                error: function() {
                    swal("Error!", "Please check the internet connection!", "error");
                }
            });
        }
        else if(accesories == '0')
        {
            var detailAccessories = "" ;
              $.ajax({
              url: "../../system/process.php",
              method: "POST",
                  dataType: "json",
              data: {
                status: status,
                assetType : assetType,
                modelType : modelType,
                rfidno : rfidno,
                sirino : sirino,
                remarks : remarks,
                box : box,
                adapter : adapter,
                cable : cable,
                accesories : accesories,
                detailAccessories : detailAccessories  
              },
              success: function(data) {
                  $('#ipadDetails').html(data);
                  $("#basicModal").modal('show');
                  $("#emptyAlert").hide();
                  $("#val-accessories-error").hide();
              },
                error: function() {
                    swal("Error!", "Please check the internet connection!", "error");
                }
            });
        }
    }
  });
    
//masukkan data ipad kedalam database
$('#saveiPad').click(function() {
    
    var status = "submitInfoIpad";
    var box = $("#val-boxs").val();
    var rfidno = $("#val-rfidNo").val();
    var sirino = $("#val-siriNo").val();
    var remarks = $("#val-remarks").val();
    var adapter = $("#val-adapters").val();
    var cable = $("#val-cables").val();
    var detailAccessories = $("#val-detailAccessoriess").val();
    var accesories = $("#val-accesoriess").val();
    var assetType = $("#val-assetType").val();
    var modelType = $("#val-modelType").val();

    if(modelType != "" && assetType != "" && rfidno != "" && sirino != "" && detailAccessories != ""){ 
        $.ajax({
          url: "../../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            assetType : assetType,
            modelType : modelType,
            rfidno : rfidno,
            sirino : sirino,
            remarks : remarks,
            box : box,
            adapter : adapter,
            cable : cable,
            detailAccessories : detailAccessories,
            accesories : accesories
          },
          success: function(data) {
              if ($.trim(data) === "Success") {
                    $("#basicModal").modal('hide');
                    $('.form-valide')[0].reset();
                    $("#myDiv").hide();
                    $(".detailAccessories").hide();

                  swal({
                       title: "Successfully!",
                       text: "1 iPad record was successfully inserted!",
                       type: "success",
                       showCancelButton: true,
                       confirmButtonColor: "#3085d6",
                       confirmButtonText: "Assign User",
                       cancelButtonText: "Done",
                       closeOnConfirm: false
                    }, function (isConfirm) {
                          if (isConfirm) {     
                              window.location.href='assignOwner.php';   
                          }
                          else{
                             location.reload(true);
                          }
                    });
                  }
			     else if ($.trim(data) === "Failed") {
				    swal("Error!", "Please check the internet connection!", "error");    
              }
                
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
//update data ipad ke dalam database
$('#updateiPad').click(function() {
    
    var status = "saveupdateIpad";
    var box = $("#val-boxs").val();
    var rfidno = $("#val-rfidNo").val();
    var sirino = $("#val-siriNo").val();
    var remarks = $("#val-remarks").val();
    var adapter = $("#val-adapters").val();
    var cable = $("#val-cables").val();
    var accesories = $("#val-accesoriess").val();
    var assetType = $("#val-assetType").val();
    var modelType = $("#val-modelType").val();
    var dateregistered = $("#val-dateregistered").val();
    var detailAccessories = $("#val-detailAccessoriess").val();

    if(modelType != "" && assetType != "" && rfidno != "" && sirino != "" ){ 
        $.ajax({
          url: "../../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            assetType : assetType,
            modelType : modelType,
            rfidno : rfidno,
            sirino : sirino,
            remarks : remarks,
            box : box,
            adapter : adapter,
            cable : cable,
            accesories : accesories,
            dateregistered : dateregistered,
            detailAccessories : detailAccessories
          },
          success: function(data) {
              if ($.trim(data) === "Success") {
                    $("#basicModal").modal('hide');
                    $('.form-valide')[0].reset();
                    $("#myDiv").hide();
                    $(".detailAccessories").hide();

                  swal({
                       title: "Successfully!",
                       text: "Update Record Successfully!",
                       type: "success",
                       showCancelButton: false,
                       confirmButtonColor: "#3085d6",
                       confirmButtonText: "Done",
                       closeOnConfirm: false
                    }, function () {
                          window.location.href='../data/iPad/listiPad.php?status=AlliPad'; 
                    });
                  }
			     else if ($.trim(data) === "Failed") {
				swal("Error!", "Please check the internet connection!", "error");    
              }
                
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
//masukkan data return ke dalam database
$('#savereturnIpad').click(function() {
    
    var status = "submitInfoReturnIpad";
    var ipadID = $("#ipadID").val();
    var ownerID = $("#ownerID").val();
    var screen = $(".val-screens").val();
    var cover = $(".val-covers").val();
    var box = $(".val-boxs").val();
    var cable = $(".val-cables").val();
    var adapter = $(".val-adapters").val();
    var accesories = $(".val-accesoriess").val();
    var otherdamage = $(".val-otherdamages").val();
    
    alert(screen);
    alert(cover);
    alert(box);
    alert(adapter);
    alert(accesories);
    alert(otherdamage);
    alert(ipadID);

    if(screen != ""){
        
        $.ajax({
          url: "../../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            ipadID : ipadID,
            ownerID : ownerID,
            screen : screen,
            cover : cover,
            box : box,
            cable : cable,
            adapter : adapter,
            otherdamage : otherdamage
          },
          success: function(data) {
              if ($.trim(data) === "Success") {
                    $("#basicModal").modal('hide');
                    $('.form-valide')[0].reset();
                    $("#myDiv").hide();
                    $(".detailAccessories").hide();

                  swal({
                       title: "Successfully!",
                       text: "Return iPad Successfully!",
                       type: "success",
                       showCancelButton: false,
                       confirmButtonColor: "#3085d6",
                       confirmButtonText: "Done",
                       closeOnConfirm: false
                    }, function () {
                          location.reload(true);
                    });
                  }
			     else if ($.trim(data) === "Failed") {
				swal("Error!", "Please check the internet connection!", "error");    
              }
                
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    

// start asign ipad n owner =================    
    
 //untuk asign ipad kepada owner dan masukkan ke dalam database
$('#saveAssignIpad').click(function() {
    var status = "submitAssignOwner";
	var ownerID = $("#ownerID").val();
	var ipadID = $("#ipadID").val();
	
    if(ownerID != "" && ipadID != "" ){ 
        $.ajax({
          url: "../../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
			ownerID : ownerID,
			ipadID : ipadID
          },
          success: function(data) {
              
              if ($.trim(data) === "Success") {
                $("#basicModal").modal('hide');
                  swal({
                       title: "Successfully!",
                       text: "Assign iPad Successfully!",
                       type: "success",
                       showCancelButton: false,
                       confirmButtonColor: "#3085d6",
                       confirmButtonText: "Done",
                       closeOnConfirm: false
                    }, function () {
                          window.location.href='../form/assignipadreceipt.php'; 
                    });
			  }
			  else if ($.trim(data) === "Failed") {
				swal("Error!", "Please check the internet connection!", "error");    
              }
          },
			error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});   

//untuk asign owner pada ipad dan masukkan ke dalam database
$('#saveAssignOwner').click(function() {
    var status = "submitAssignOwner";
    var ownerID = $("#ownerID").val();
	var ipadID = $("#ipadID").val();

    if(ownerID != "" && ipadID != ""){ 
        $.ajax({
          url: "../../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            ownerID : ownerID,
			ipadID : ipadID,
          },
          success: function(data) {
              
              if ($.trim(data) === "Success") {
                $("#basicModal").modal('hide');
                  swal({
                       title: "Successfully!",
                       text: "Asign iPad Successfully!",
                       type: "success",
                       showCancelButton: false,
                       confirmButtonColor: "#3085d6",
                       confirmButtonText: "Done",
                       closeOnConfirm: false
                    }, function () {
                          window.location.href='../'; 
                    });
			  }
			  else if ($.trim(data) === "Failed") {
				swal("Error!", "Please check the internet connection!", "error");    
              }
          },
			error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
// end asign ipad n owner ========================


    


 // ============== Preview Modal ================
  
 //for Add User page (adduser.php)
 //display the modal for user information
$('#btnPreviewUser').click(function() {
    var status = "previewInfoUser";
    var usersName = $("#val-usersName").val();
	var usersEmail = $("#val-usersEmail").val();
    
    if(usersName == "" || usersEmail == ""){
       $(".form-valide").valid();
    }

    if(usersName != "" && usersEmail != "" ){ 
        $.ajax({
          url: "../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            usersName : usersName,
            usersEmail : usersEmail
          },
          success: function(data) {
              $('#usersDetails').html(data);
              $("#basicModal").modal('show');
          },
			error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
  });

$('#btnPreviewUpdateUser').click(function() {
    var status = "previewInfoUpdateUser";
    var usersName = $("#val-usersName").val();
	var usersEmail = $("#val-usersEmail").val();
    var usersID = $("#val-usersID").val();
    
    if(usersName == "" || usersEmail == ""){
       $(".form-valide").valid();
    }

    if(usersName != "" && usersEmail != "" ){ 
        $.ajax({
          url: "./system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            usersName : usersName,
            usersEmail : usersEmail,
            usersID : usersID
          },
          success: function(data) {
              $('#usersDetails').html(data);
              $("#basicModal").modal('show');
          },
			error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
  });

 //for Assign iPad to user (assignOwner.php)
 //display the modal for user information and rent ipad
$('#btnNextAssignOwner').click(function() {
    var status = "previewInfoAssignOwner";
	var ipadID = $("#val-ipadID").val();
    var ownerID = $("#val-ownerID").val();
    
    if(ownerID == ""){
       $(".form-valide").valid();
    }

    if(ownerID != "" ){ 
        $.ajax({
          url: "../../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            ipadID : ipadID,
            ownerID : ownerID
          },
          success: function(data) {
              $('#ownerDetails').html(data);
              $("#basicModal").modal('show');
              $("#emptyAlert").hide();
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
  });
    
 //untuk display modal return ipad
$('#btnNextReturnIpad').click(function() {
    var status = "ReturnIpad";
	var ipadID = $("#ipadID").val();
    var ownerID = $("#ownerID").val();
    
    var screen = $("input[name='val-screen']:checked").val();
    var cover = $("input[name='val-cover']:checked").val();
    var box = $("input[name='val-box']:checked").val();
    var cable = $("input[name='val-cable']:checked").val();
    var adapter = $("input[name='val-adapter']:checked").val();
    var accesories = $("input[name='val-accesories']:checked").val();
    var otherdamage = $("input[name='val-otherdamage']:checked").val();
    var damageDescribe = $("#val-damageDescribe").val();
    
    if(screen == undefined || cover == undefined || cable == undefined || adapter == undefined || accesories == undefined || otherdamage == undefined){
       $(".form-valide").valid();
    }

    if(screen != undefined && cover != undefined && cable != undefined && adapter != undefined && accesories != undefined && otherdamage != undefined ){ 
        $.ajax({
          url: "../../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            ipadID : ipadID,
            ownerID : ownerID,
            screen : screen,
            cover : cover,
            box : box,
            cable : cable,
            adapter : adapter,
            accesories : accesories,
            damageDescribe : damageDescribe,
            otherdamage : otherdamage
          },
          success: function(data) {
              $('#returnFormDetails').html(data);
              $("#basicModal").modal('show');
              $("#emptyAlert").hide();
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
  });
    

$('#radioPreviewbtn').click(function() {
	
    var status = "LoginSystem";
    var otherdamage_return = $("#otherdamage_return input:radio:checked").val();
    var accesories_return = $("#accesories_return input:radio:checked").val();
    var screen_return = $("#screen_return input:radio:checked").val();
    var cover_return = $("#cover_return input:radio:checked").val();
    var cable_return = $("#cable_return input:radio:checked").val();
    var adapter_return = $("#adapter_return input:radio:checked").val();
    
	if(otherdamage_return == undefined || accesories_return == undefined || screen_return == undefined || 
       cover_return == undefined || cable_return == undefined || adapter_return == undefined){
		$(".form-valide").valid();
	}
	
    if(otherdamage_return != undefined && accesories_return != undefined && screen_return != undefined && 
       cover_return != undefined && cable_return != undefined && adapter_return != undefined ){ 
        $.ajax({
          url: "system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            email : email,
            password : password
          },
          success: function(data) {
			  if ($.trim(data) === "Success") {
                $('.form-valide')[0].reset();
                window.location.href='./';
			  }
			  else if ($.trim(data) === "Failed") {
				swal("Invalid!", "email or password is invalid!", "error");
                $("#val-password").val("");
			  }
                
          },
			error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
    
    //for add new ipad (newipad.php)
    //display the modal for ipad information
 $('#btnNextAssignIpad').click(function() {
    var status = "previewInfoAssignIpad";
    
    var rfidno = $("#val-rfidNo").val();
    var IDowner = $("#val-IDowner").val();

    if(rfidno == ""){
       $(".form-valide").valid();
    }

    if(rfidno != "" && IDowner != "" ){ 
        $.ajax({
          url: "../../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            rfidno : rfidno,
            IDowner : IDowner
          },
          success: function(data) {
              $('#ipadOwnerDetails').html(data);
              $("#basicModal").modal('show');
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
  });
    
    
  
  // ============== Dropdown Select ================

 //for Assign Owner (assignowner.php)
 //dropdown select the department
$('#val-ownerDeptSelect').on('change', function(){
    var demovalue = $(this).val(); 
    
    if(demovalue == "InputText"){
        $("#myDivDept").show();
    }
    else{
        $("#myDivDept").hide();
    }
});
    



//for Assign Owner (assignowner.php)
 //dropdown select the name
$('#val-ownerNameSelect').on('change', function(){
    var demovalue = $(this).val(); 
    
    if(demovalue == "InputText"){
        $("#myDivName").show();
        $("#myDivDept").show();
    }
    else{
        $("#myDivName").hide();
    }
});

$('#val-assetTypeSelect').on('change', function(){
    var demovalue = $(this).val(); 
    
    if(demovalue == "InputText"){
        $("#myDivAssetType").show();
        $("#myDivAssetType").show();
    }
    else{
        $("#myDivAssetType").hide();
    }
});

$('#val-modelTypeSelect').on('change', function(){
    var demovalue = $(this).val(); 
    
    if(demovalue == "InputText"){
        $("#myDivModelType").show();
        $("#myDivModelType").show();
    }
    else{
        $("#myDivModelType").hide();
    }
});
    
$('#InputText').click(function() {
    if($(this).is(":checked")) {
        $(".otherdetailAccessories").show();
        $("#val-accessories-error-2").hide();
    }
    else{
        $(".otherdetailAccessories").hide();
    }
});

$('.val-otherAccessoriesSelect2').on('change', function(){
    var demovalue = $(this).val(); 
    
    if(demovalue == "InputText"){
        $(".otherAccessoriesSelect2").show();
    }
    else{
        $(".otherAccessoriesSelect2").hide();
    }
});


    
//for owner view page (listowner.php)
//display the modal for owner information
$('.viewIpad').click(function() {
    var serialNo = $(this).attr("id");
    var status = "viewOwner";

    if(serialNo != "" ){ 
        $.ajax({
          url: "./../../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            serialNo : serialNo
          },
          success: function(data) {
                $('#ipadViewDetails').html(data);
                $("#ipadViewmodal").modal('show');
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
    
    
 //untuk review data owner sebelum hantar ke database  
 $('#btnNextOwner').click(function() {
    var status = "previewInfoOwner";
     var IDowner = $("#IDowner").val();
     
    if($(".val-ownerDept").val() != undefined){
        var ownerDept = $(".val-ownerDept").val();
        var addDept = 'exist';
    }
    else if($(".val-ownerDept").val() == undefined){
        if($(".val-ownerDeptSelect").val() == 'InputText'){
            var ownerDept = $(".val-ownerDept2").val();
            var addDept = 'exist';
        }
        else if($(".val-ownerDeptSelect").val() != 'InputText'){
            var ownerDept = $(".val-ownerDeptSelect").val();
            var addDept = '';
        }
    }
    
     
    var ownerName = $("#val-ownerName").val();
     
    if(ownerName == "" && ownerDept == ""){
        $(".form-valide").valid();
    }

    if(ownerName != "" && ownerDept != "" ){ 
        $.ajax({
          url: "../../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            ownerName : ownerName,
            ownerDept : ownerDept,
            addDept : addDept,
            IDowner : IDowner
          },
          success: function(data) {
              $('#ownerDetails').html(data);
              $("#basicModal").modal('show');
              $("#emptyAlert").hide();
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
  });  
    

 //untuk review data department sebelum hantar ke database  
 $('#btnNextDept').click(function() {
    var status = "previewInfoDept";

    var ownerDept = $("#val-ownerDept").val();
    var IDdept = $("#IDdept").val();
     
    if(ownerDept == ""){
        $(".form-valide").valid();
    }

    if(ownerDept != "" ){ 
        $.ajax({
          url: "../../system/process.php",
          method: "POST",
          dataType: "json",
          data: {
            status: status,
            ownerDept : ownerDept,
            IDdept:IDdept
          },
          success: function(data) {
              $('#ownerDetails').html(data);
              $("#basicModal").modal('show');
              $("#emptyAlert").hide();
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
  }); 



    
    
// ========== Function (D) ==========
//Display & hide the new Accessories div
$("input[name$='val-accesories']").click(function() {
    var demovalue = $(this).val(); 

    if(demovalue == "1"){
        $(".detailAccessories").show();
    }
    else{
        $(".detailAccessories").hide();
    }
});

      // ============== Radio Button ================    
    
$("input[name$='val-otherdamage']").click(function() {
    var demovalue = $(this).val(); 
    
    if(demovalue == "1"){
        $("#myDivOthers").show();
    }
    else{
        $("#myDivOthers").hide();
    }
}); 

// ============== Assign User modal ================ 
$('.AssignUser').click(function() {
    var ipadID = $(this).attr("id");
    var status = "AssignUser";

    if(ipadID != "" ){ 
        $.ajax({
          url: "../system/process2.php",
          method: "POST",
          data: {
            status: status,
            ipadID : ipadID
          },
          success: function(data) {
                $('#basicModalDetails').html(data);
                $("#basicModal").modal('show');
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
// ============== Assign User modal ================ 
$('.AssignUsers').click(function() {
    var ipadID = $(this).attr("id");
    var status = "AssignUser";

    if(ipadID != "" ){ 
        $.ajax({
          url: "../../../system/process2.php",
          method: "POST",
          data: {
            status: status,
            ipadID : ipadID
          },
          success: function(data) {
                $('#basicModalDetails').html(data);
                $("#basicModal").modal('show');
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
// ============== Assign Ipad modal ================ 
$('.AssignIpad').click(function() {
    var ownerID = $(this).attr("id");
    var status = "AssignIpad";

    if(ownerID != "" ){ 
        $.ajax({
          url: "../system/process2.php",
          method: "POST",
          data: {
            status: status,
            ownerID : ownerID
          },
          success: function(data) {
                $('#basicModalDetails').html(data);
                $("#basicModal").modal('show');
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
// ============== view details inuse ipad modal ================ 
$('.viewDetailsInUse').click(function() {
    var ipadOwnerID = $(this).attr("id");
    var status = "viewDetailsInUse";

    if(ipadOwnerID != "" ){ 
        $.ajax({
          url: "../system/process2.php",
          method: "POST",
          data: {
            status: status,
            ipadOwnerID : ipadOwnerID
          },
          success: function(data) {
                $('#basicModalDetails').html(data);
                $("#basicModal").modal('show');
          },
            error: function() {
				swal("Error!", "Please check the internet connection!", "error");
			}
        });
    }
});
    
$('#SelectOwnerID').change(function(){
        var ownerID = $('#SelectOwnerID').val() ;
        
        if(ownerID == ''){
            $('#btnNextAssignOwner').prop('disabled', true);
            $('#detailsOwner').hide();
            $('#addNewUser').hide();
        }
        else if(ownerID == 'others') {
            $('#addNewUser').show().fadeIn(1800);
            $('#detailsOwner').hide();
            
            $('#btnNextAssignOwner').prop('disabled', true);

            function validateNextButton() {
                var buttonDisabled = $('#val-ownerDept').val().trim() === '' || $('#val-ownerName').val().trim() === '';
                $('#btnNextAssignOwner').prop('disabled', buttonDisabled);
            }

            $('#val-ownerDept').on('keyup', validateNextButton);
            $('#val-ownerName').on('keyup', validateNextButton);
            
        } else if(ownerID != 'others') {
            var status = "detailsOwner";
            $('#btnNextAssignOwner').removeAttr('disabled');
            
            $.ajax({  
                url:"../system/process.php",  
                method:"POST",  
                data:{status:status,ownerID:ownerID},  
                success:function(data){ 
                     $('#detailsOwner').show();
                     $('#detailsOwner').html(data);
                     $('#addNewUser').hide();
                }  
           });
        }
    });
    
    
    $('.SelectOwnerIDform').change(function(){
        var ownerID = $('#val-ownerID').val() ;
        
        if(ownerID == ''){
            $('#btnNextAssignOwner').prop('disabled', true);
            $('#detailsOwner').hide();
            $('#addNewUser').hide();
        }
        else if(ownerID == 'others') {
            $('#addNewUser').show().fadeIn(1800);
            $('#detailsOwner').hide();
            
            $('#btnNextAssignOwner').prop('disabled', true);

            function validateNextButton() {
                var buttonDisabled = $('#val-ownerDept').val().trim() === '' || $('#val-ownerName').val().trim() === '';
                $('#btnNextAssignOwner').prop('disabled', buttonDisabled);
            }

            $('#val-ownerDept').on('keyup', validateNextButton);
            $('#val-ownerName').on('keyup', validateNextButton);
            
        } else if(ownerID != 'others') {
            var status = "detailsOwner";
            $('#btnNextAssignOwner').removeAttr('disabled');
            
            $.ajax({  
                url:"./../../system/process.php",  
                method:"POST", 
                dataType:"json",
                data:{status:status,ownerID:ownerID},  
                success:function(data){ 
                     $('#detailsOwner').show();
                     $('#detailsOwner').html(data);
                     $('#addNewUser').hide();
                }  
           });
        }
    });
    
    $('#SelectIpadID').change(function(){
        var ipadID = $('#SelectIpadID').val() ;
        
        if(ipadID != '') {
            var status = "detailsIpad";
            $('#btnNextAssignIpad').removeAttr('disabled');
            $.ajax({  
                url:"../system/process.php",  
                method:"POST",  
                dataType:"json",
                data:{status:status,ipadID:ipadID},  
                success:function(data){ 
                     $('#detailsIpad').show();
                     $('#detailsIpad').html(data);
                }  
           }); 
        }
        else{
            $('#btnNextAssignIpad').prop('disabled', true);
            $('#detailsIpad').hide();
        }
    });
    
     $('.SelectIpadID').change(function(){
        var ipadID = $('#val-rfidNo').val() ;
        
        if(ipadID != '') {
            var status = "detailsIpad";
            $('#btnNextAssignIpad').removeAttr('disabled');
            $.ajax({  
                url:"../../system/process.php",  
                method:"POST",  
                dataType:"json",
                data:{status:status,ipadID:ipadID},  
                success:function(data){ 
                     $('#detailsIpad').show();
                     $('#detailsIpad').html(data);
                }  
           }); 
        }
        else{
            $('#btnNextAssignIpad').prop('disabled', true);
            $('#detailsIpad').hide();
        }
    });
    
$("#val-rfidNo").keyup(function () {
    var rfidNo = $("#val-rfidNo").val();
    var status = "checkRfidNo";

    $.ajax({
        url:"../../system/process.php",
        method:"POST",
        dataType:"json",
        data:{rfidNo:rfidNo,status:status},
        success:function(data)
        {
            if(data === "Success"){
                swal("Warning!", "RFID number is already registered!", "warning");
                $("#btnNextNewiPad").prop('disabled', true);
            }
            else{
                $("#btnNextNewiPad").prop('disabled', false);
            }
        }
    });
});
    
$("#val-siriNo").keyup(function () {
    var serialNo = $("#val-siriNo").val();
    var status = "checkSerialNo";

    $.ajax({
        url:"../../system/process.php",
        method:"POST",
        dataType:"json",
        data:{serialNo:serialNo,status:status},
        success:function(data)
        {
            if(data === "Success"){
                swal("Warning!", "Serial number is already registered!", "warning");
                $("#btnNextNewiPad").prop('disabled', true);
            }
            else{
                $("#btnNextNewiPad").prop('disabled', false);
            }
        }
    });
});
    
    $("#uploadFile").submit (function (event){
        event.preventDefault();
        var formData = new FormData(this);
        
  
            $.ajax({
              url: "../../../system/process.php",
              method: "POST",
              dataType:"json",
              contentType: false,
              cache: false,
              processData:false,
              data: formData,
              success: function(data) {
                  if ($.trim(data) === "Failed"){
                      swal("Error!", "Please check the internet connection!", "error");
                  }
                  else if ($.trim(data) === "Faileds"){
                      swal("Error!", "Only .PDF format is allowed!", "warning");
                  }
                  else {
                    swal("Successfully!", "Upload Form Successfully!", "success");
                      $("#load").load("../../../system/ipad/uploadFixedReceipt-2.php", {
                           fileID: data
                       });
                  }
              },
                error: function() {
                    swal("Error!", "Please check the internet connection!", "error");
                }
            });
    });
    
    $("#uploadFileReturn").submit (function (event){
        event.preventDefault();
        var formData = new FormData(this);
        
  
            $.ajax({
              url: "../../../system/process.php",
              method: "POST",
              dataType:"json",
              contentType: false,
              cache: false,
              processData:false,
              data: formData,
              success: function(data) {
                  if ($.trim(data) === "Failed"){
                      swal("Error!", "Please check the internet connection!", "error");
                  }
                  else if ($.trim(data) === "Faileds"){
                      swal("Error!", "Only .PDF format is allowed!", "warning");
                  }
                  else {
                    swal("Successfully!", "Upload Form Successfully!", "success");
                      $("#load").load("../../../system/ipad/uploadFixedReceipt-2.php", {
                           fileID: data
                       });
                  }
              },
                error: function() {
                    swal("Error!", "Please check the internet connection!", "error");
                }
            });
    });
    
    $('#val-otherAccessoriesSelect').on('change', function(){
    var demovalue = $(this).val(); 
    
    
    if(demovalue == "InputText"){
        $(".otherdetailAccessories").show();
    }
    else{
        $(".otherdetailAccessories").hide();
    }
});
    
    $('.addDateView').click(function() {
        var ipadOwnerID = $(this).attr("id");
        var status = "displayDateView";
    

        if(ipadOwnerID != "" ){ 
            $.ajax({
              url: "../../../system/process.php",
              method: "POST",
                dataType:"json",
              data: {
                status: status,
                ipadOwnerID : ipadOwnerID
              },
              success: function(data) {
                    $('#basicModalDetailsView').html(data);
                    $("#basicModalDateView").modal('show');
                    $("#basicModal").modal('hide');
              },
                error: function() {
                    swal("Error!", "Please check the internet connection!", "error");
                }
            });
        }
    });
    
    $('.addDateDownload').click(function() {
        var ipadOwnerID = $(this).attr("id");
        var status = "displayDateDownload";
    

        if(ipadOwnerID != "" ){ 
            $.ajax({
              url: "../../../system/process.php",
              method: "POST",
                dataType:"json",
              data: {
                status: status,
                ipadOwnerID : ipadOwnerID
              },
              success: function(data) {
                    $('#basicModalDetailsDownload').html(data);
                    $("#basicModalDateDownload").modal('show');
                    $("#basicModal").modal('hide');
              },
                error: function() {
                    swal("Error!", "Please check the internet connection!", "error");
                }
            });
        }
    });
    
    $('.addDateViewSearch').click(function() {
        var ipadOwnerID = $(this).attr("id");
        var status = "displayDateView";
    

        if(ipadOwnerID != "" ){ 
            $.ajax({
              url: "../../system/process.php",
              method: "POST",
                dataType:"json",
              data: {
                status: status,
                ipadOwnerID : ipadOwnerID
              },
              success: function(data) {
                    $('#basicModalDetailsView').html(data);
                    $("#basicModalDateView").modal('show');
                    $("#basicModal").modal('hide');
              },
                error: function() {
                    swal("Error!", "Please check the internet connection!", "error");
                }
            });
        }
    });
    
    $('.addDateDownloadSearch').click(function() {
        var ipadOwnerID = $(this).attr("id");
        var status = "displayDateDownload";
    

        if(ipadOwnerID != "" ){ 
            $.ajax({
              url: "../../system/process.php",
              method: "POST",
                dataType:"json",
              data: {
                status: status,
                ipadOwnerID : ipadOwnerID
              },
              success: function(data) {
                    $('#basicModalDetailsDownload').html(data);
                    $("#basicModalDateDownload").modal('show');
                    $("#basicModal").modal('hide');
              },
                error: function() {
                    swal("Error!", "Please check the internet connection!", "error");
                }
            });
        }
    });
    
});

