$( document ).ready(function() {
    $("#cavity").change(function(){
        var cavity= $(this).val();
        var cavRight = document.getElementById("right-part");
        var cavLeft = document.getElementById("left-part");

        if(cavity == "1-Right"){
            cavLeft.value = "";
            cavLeft.disabled = true;
            cavRight.disabled = false;
            cavRight.required = true;
            cavLeft.required = false;
        }else if(cavity == "1-Left"){
            cavRight.value = "";
            cavRight.disabled = true;
            cavLeft.disabled = false;
            cavLeft.required = true;
            cavRight.required = false;
        }else if(cavity == "2"){
            cavRight.disabled = false;
            cavLeft.disabled = false;
            cavRight.required = true;
            cavLeft.required = true;
        }else{
            cavLeft.value = "";
            cavRight.value = "";
            cavRight.required = false;
            cavLeft.required = false;
            cavRight.disabled = true;
            cavLeft.disabled = true;
        }
    });
});