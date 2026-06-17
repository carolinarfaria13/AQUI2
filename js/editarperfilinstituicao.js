document.addEventListener("DOMContentLoaded", function() {

    var navbar = document.querySelector(".nav-fixav");

    if (navbar) {
        window.addEventListener("scroll", function() {

            if (window.scrollY > 20) {
                navbar.classList.add("nav-scrolled");
            }
            else {
                navbar.classList.remove("nav-scrolled");
            }

        });
    }
});

document.addEventListener("DOMContentLoaded", function() {
    var inputFotoInst = document.getElementById('input-foto-inst');

    if (inputFotoInst) {
        inputFotoInst.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    var imgPreview = document.getElementById('preview-foto-inst');
                    if (imgPreview) {
                        imgPreview.src = event.target.result;
                    }
                };

                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }
});

