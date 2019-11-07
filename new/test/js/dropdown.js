function expandSignIn(){
    document.getElementById("signInBtn").style.height= "175px";
    document.getElementById("signInForm").style.display= "block";
}

function expandSignUp(){
    document.getElementById("signUpBtn").style.height= "265px";
    document.getElementById("signUpForm").style.display= "block";
}

function expandMyRooms(){
    document.getElementById("myRoomsBtn").style.height= "265px";
    document.getElementById("myRoomsForm").style.display= "block";
}

function expandChangePassword(){
    document.getElementById("changePasswordBtn").style.height= "225px";
    document.getElementById("changePasswordForm").style.display= "block";
}

function expandFileUpload(){
    
    if(document.getElementById("roomName").value !== "" && document.getElementById("roomDescription").value !== "" && document.getElementById("piece").checked) {
        $(document).ready(function() { 
            $("#doneBtn").fadeIn("1000");
            $("#fileUploadBtn").fadeIn("1000");
        });
        document.getElementById("fileUploadBtn").style.height= "250px";
        document.getElementById("fileUploadBtn").style.height= "250px";
        document.getElementById("fileUploadForm").style.display= "block";
    }else{
        alert("Fill in the Room Name, Type and Description!");
    }
}

function expandPin(){
    document.getElementById("perfectBtn").style.height= "225px";
    document.getElementById("perfectForm").style.display= "block";
}