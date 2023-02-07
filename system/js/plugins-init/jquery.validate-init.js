jQuery(".form-valide").validate({
    rules: {
        "val-email": {
            required: !0,
            email: !0
        },
        "val-password": {
            required: !0,
            minlength: 5
        },
        "val-CurrentPassword": {
            required: !0,
            minlength: 5
        },
        "val-passwordConfirmed": {
            required: !0,
            equalTo: "#val-password"
        },
		"val-assetTypeSelect": {
            required: !0
        },
        "val-modelTypeSelect": {
            required: !0
        },
        "val-suggestions": {
            required: !0,
            minlength: 5
        },
        "val-rfidNo": {
            required: !0,
            minlength: 3,
			digits: !0
        },
        "val-siriNo": {
            required: !0,
            minlength: 3
        },
        "val-ownerName": {
            required: !0,
            minlength: 3
        },
        "val-ownerDept": {
            required: !0
        },
		"val-ownerNameSelect": {
            required: !0
        },
        "val-ownerDeptSelect": {
            required: !0
        },
		"val-usersName": {
            required: !0,
			minlength: 10
        },
		"val-usersEmail": {
            required: !0,
            email: !0
        },
        "val-otherdamage": {
            required: !0
        },
        "val-accesories": {
            required: !0
        },
        "val-adapter": {
            required: !0
        },
        "val-cable": {
            required: !0
        },
        "val-cover": {
            required: !0
        },
        "val-screen": {
            required: !0
        }
        ,
        "val-box": {
            required: !0
        }
        
    },
    messages: {
        "val-email": "Please enter the valid email address",
		"val-usersEmail": {
            required: "Please provide the staff email",
            email: "Please enter the valid email address"
        },
        "val-password": {
            required: "Please provide the password",
            minlength: "Your password must be at least 5 characters long"
        },
        "val-CurrentPassword": {
            required: "Please provide the current password",
            minlength: "Your password must be at least 5 characters long"
        },
        "val-passwordConfirmed": {
            required: "Please provide the confirm password",
            minlength: "Your password must be at least 5 characters long",
            equalTo: "Please enter the same password as above"
        },
		
		"val-usersName": {
            required: "Please enter the staff name",
            minlength: "Your name must be at least 10 characters long"
        },
        
        "val-assetType": {
            required: "Please enter the device name",
            minlength: "Your Device Name must consist of at least 3 characters"
        },
        "val-modelType": {
            required: "Please enter the asset name",
            minlength: "Your Model Name must consist of at least 3 characters"
        },
        "val-rfidNo": {
            required: "Please enter the RFID number",
            minlength: "Your RFID Number must consist of at least 3 numbers",
			digits: "Must be the number only"
        },
        "val-siriNo": {
            required: "Please enter the serial number",
            minlength: "Your serial Number must consist of at least 3 characters and numbers"
        },
        "val-ownerName": {
            required: "Please enter the owner name",
            minlength: "Your Siri Number must consist of at least 3 characters and numbers"
        },
        "val-ownerDept": {
            required: "Please select the owner depatment",
            minlength: "Your Siri Number must consist of at least 3 characters and numbers"
        },
		"val-assetTypeSelect": {
            required: "Please select the device type"
        },
        "val-modelTypeSelect": {
            required: "Please select the model type"
        },
        "val-ownerDeptSelect": {
            required: "Please select the department / division"
        },
		"val-ownerNameSelect": {
            required: "Please select the asset type"
        },
        "val-otherdamage": {
            required: "Please choose one"
        },
        "val-accesories": {
            required: "Please choose one"
        },
        "val-adapter": {
            required: "Please choose one"
        },
        "val-cable": {
            required: "Please choose one"
        },
        "val-cover": {
            required: "Please choose one"
        },
        "val-screen": {
            required: "Please choose one"
        },
        "val-box": {
            required: "Please choose one"
        },
        
    },

    ignore: [],
    errorClass: "invalid-feedback animated fadeInUp",
    errorElement: "div",
    errorPlacement: function(e, a) {
        jQuery(a).parents(".form-group > div").append(e)
    },
    highlight: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
    },
    success: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
    },
});


$('#btnAddUser').click( function() { 
    $(".form-valide").valid();  // test the form for validity
});





  
        















