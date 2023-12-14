jQuery(document).ready(function($) {
    // Attach event using event delegation
    $(document).on('submit', '.jury-voting-form', function(e) {
        e.preventDefault();

        var formData = $(this).serialize() + '&action=handle_judge_voting&nonce=' + $('#judge_vote_nonce').val();

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: formData,
            success: function(response) {
                console.log(response);
                alert(response); // Displaying response for user feedback
            },
            error: function() {
                console.log('error');
            }
        });
    });
});



function openModal1() {
    document.getElementById("myModal1").style.display = "flex";
  }
  
  function closeModal1() {
    document.getElementById("myModal1").style.display = "none";
  //    location.reload();
  }
  
  var slideIndex1 = 1;
  showSlides1(slideIndex1);
  
  function plusSlides1(n) {
    showSlides1((slideIndex1 += n));
  }
  
  function currentSlide1(n) {
    showSlides1((slideIndex1 = n));
  }
  
  function showSlides1(n) {
    var i;
    var slides1 = document.getElementsByClassName("mySlides1");
    var dots1 = document.getElementsByClassName("demo");
    var captionText1 = document.getElementById("caption");
    if (n > slides1.length) {
      slideIndex1 = 1;
    }
    if (n < 1) {
      slideIndex1 = slides1.length;
    }
    for (i = 0; i < slides1.length; i++) {
      slides1[i].style.display = "none";
    }
    for (i = 0; i < dots1.length; i++) {
      dots1[i].className = dots1[i].className.replace(" active", "");
    }
    if (slides1 && slides1.length > 0 && slideIndex1 >= 1 && slideIndex1 <= slides1.length) {
        slides1[slideIndex1 - 1].style.display = "flex";
    }    // dots1[slideIndex1 - 1].className += " active";
    // captionText.innerHTML = dots1[slideIndex1 - 1].alt;
  }


  jQuery(document).ready(function($) {
    $('.painting-gallery-container .image-meta-block img').click(function() {
        var imgSrc = $(this).attr('src');
        var title = $(this).data('title');
        var width = $(this).data('width');
        var height = $(this).data('height');
        var medium = $(this).data('medium');

        // Update the painting information container
        $('.painting-information-container img').attr('src', imgSrc);
        $('.painting-information-container').find('p').eq(0).text('Painting Title: ' + title);
        $('.painting-information-container').find('p').eq(1).text('Dimensions: ' + width + ' x ' + height);
        $('.painting-information-container').find('p').eq(2).text('Medium: ' + medium);
    });
});
