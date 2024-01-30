jQuery(document).ready(function ($) {
  // Attach event using event delegation
  $(document).on("submit", ".jury-voting-form", function (e) {
    e.preventDefault();

    var formData =
      $(this).serialize() +
      "&action=handle_judge_voting&nonce=" +
      $("#judge_vote_nonce").val();
    var formSuccess = jQuery(".judgeSubmit1", this);

    $.ajax({
      type: "POST",
      url: ajax_object.ajax_url,
      data: formData,
      success: function (response) {
        $(formSuccess).addClass("success");
        $(formSuccess).val("Success!");
      },
      error: function () {
        console.log("error");
      },
    });
  });

  jQuery(".modalJuror").on("click", ".judgeSubmit1", function () {
    var submitButton = $(this);
    setTimeout(function () {
      jQuery(submitButton).removeClass("success");
      jQuery(submitButton).val("Vote");
    }, 5000);
  });

  let currentPage = 1;
  const totalPages = 5; // Set this to your total number of pages
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
  if (
    slides1 &&
    slides1.length > 0 &&
    slideIndex1 >= 1 &&
    slideIndex1 <= slides1.length
  ) {
    slides1[slideIndex1 - 1].style.display = "flex";
  } // dots1[slideIndex1 - 1].className += " active";
  // captionText.innerHTML = dots1[slideIndex1 - 1].alt;
}

jQuery(document).ready(function ($) {
  $(document).on(
    "click",
    ".painting-gallery-container .image-meta-block img",
    function () {
      var imgSrc = $(this).attr("src");
      var title = $(this).data("title");
      var width = $(this).data("width");
      var height = $(this).data("height");
      var medium = $(this).data("medium");
      var support = $(this).data("support");

      $(this)
        .closest(".mySlides1")
        .find(".applicant-info-container")
        .css("display", "none");
      $(this)
        .closest(".mySlides1")
        .find(".show-voting-information")
        .css("display", "none");
      $(this).closest(".mySlides1").find(".formInputs").css("display", "none");
      $(this)
        .closest(".mySlides1")
        .find(".painting-info-container")
        .css("display", "block");
      $(this)
        .closest(".mySlides1")
        .find(".show-applicant-information")
        .css("display", "block");

      // Update the painting information container
      $(this)
        .closest(".painting-gallery-container")
        .siblings(".left-container-main")
        .attr("src", imgSrc);
      $(this)
        .closest(".mySlides1")
        .find(".painting-info-container .pnt-title")
        .text("Painting Title: " + title);
      $(this)
        .closest(".mySlides1")
        .find(".painting-info-container .pnt-dimen")
        .text("Dimensions: " + width + " x " + height);
      $(this)
        .closest(".mySlides1")
        .find(".painting-info-container .pnt-medm")
        .text("Medium: " + medium);
      $(this)
        .closest(".mySlides1")
        .find(".painting-info-container .pnt-sprt")
        .text("Support: " + support);
    }
  );
  $(document).on("click", ".show-applicant-information", function () {
    var headshotUrl = $(this).data("headshot-url"); // Get the headshot URL from the data attribute

    $(this).css("display", "none");
    $(this).siblings(".show-voting-information").css("display", "block");
    // Reset the image src to the headshot URL
    $(this)
      .closest(".mySlides1")
      .find(".left-container-main")
      .attr("src", headshotUrl);

    $(this)
      .closest(".entry-content")
      .siblings(".applicant-info-container")
      .css("display", "block");
    $(this)
      .closest(".entry-content")
      .siblings(".painting-info-container")
      .css("display", "none");
    $(this)
      .closest(".entry-content")
      .find(".formInputs")
      .css("display", "none");
  });

  $(document).on("click", ".show-voting-information", function () {
    $(this).css("display", "none");
    $(this).siblings(".show-applicant-information").css("display", "block");

    $(this)
      .closest(".button-action-wrapper")
      .siblings(".formInputs")
      .css("display", "block");
    $(this)
      .closest(".modalRightCol")
      .find(".applicant-info-container")
      .css("display", "none");
    $(this)
      .closest(".modalRightCol")
      .find(".painting-info-container")
      .css("display", "none");
  });
});

jQuery(document).ready(function ($) {
  // Attach the click event to a static parent element
  // Delegating it to the favorite buttons
  $(document).on("click", ".favorite-button", function () {
    var button = $(this);
    var postId = button.data("post-id");
    var isFavorite = button.attr("aria-pressed") === "true";

    $.ajax({
      type: "POST",
      url: ajax_object.ajax_url,
      data: {
        action: "toggle_favorite",
        post_id: postId,
        favorite: !isFavorite,
      },
      success: function (response) {
        if (response.success) {
          button.text(response.data.button_text);
          button.attr("aria-pressed", response.data.is_favorite);
        }
      },
    });
  });
});

document.addEventListener("DOMContentLoaded", (event) => {
  const accordionContainer = document.querySelector("#myModal1"); // Replace with your accordion container's selector

  function closeAllAccordions() {
    document.querySelectorAll(".accordion-button").forEach((button) => {
      button.classList.remove("active");
      button.nextElementSibling.style.display = "none";
    });
  }

  if (accordionContainer) {
    accordionContainer.addEventListener("click", function (event) {
      const target = event.target;

      if (target && target.classList.contains("accordion-button")) {
        // Close all accordions before toggling the current one
        if (!target.classList.contains("active")) {
          closeAllAccordions();
        }

        target.classList.toggle("active");
        const content = target.nextElementSibling;
        if (content.style.display === "block") {
          content.style.display = "none";
        } else {
          content.style.display = "block";
        }
      }
    });
  }

  // Open the first accordion section by default
  const firstAccordionButton =
    accordionContainer.querySelector(".accordion-button");
  if (firstAccordionButton) {
    firstAccordionButton.classList.add("active");
    firstAccordionButton.nextElementSibling.style.display = "block";
  }
});

function initializeForm(form) {
  let currentPage = 1;
  const totalPages = 6; // Total number of pages in the form

  function showPage(pageNumber) {
    for (let i = 1; i <= totalPages; i++) {
      const page = form.querySelector(".formPage" + i);
      page.style.display = "none";
    }

    const currentPageElement = form.querySelector(".formPage" + pageNumber);
    currentPageElement.style.display = "flex";

    // Update the image source
    const newImageSrc = currentPageElement.getAttribute("data-image");
    if (newImageSrc) {
      const imageToUpdate = form
        .closest(".mySlides1")
        .querySelector(".modalLeftCol > img");
      if (imageToUpdate) {
        imageToUpdate.src = newImageSrc;
      }
    }

    form.querySelector(".prevBtnVP").style.display =
      pageNumber === 1 ? "none" : "inline";
    form.querySelector(".nextBtnVP").style.display =
      pageNumber === totalPages ? "none" : "inline";
  }

  function changePage(step) {
    currentPage += step;
    showPage(currentPage);
  }

  form
    .querySelector(".prevBtnVP")
    .addEventListener("click", () => changePage(-1));
  form
    .querySelector(".nextBtnVP")
    .addEventListener("click", () => changePage(1));

  showPage(currentPage);
}

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".jury-voting-form").forEach(initializeForm);
});

function setupTotalCalculationForPage(page) {
  // Find the total field on the page
  const totalField = page.querySelector('[name*="_total"]');
  if (!totalField) return;

  totalField.readOnly = true; // Making the total field read-only

  // Function to calculate and update total
  function updateTotal() {
    let total = 0;
    const inputFields = page.querySelectorAll(
      'input[type="number"]:not([name*="_total"])'
    );

    inputFields.forEach((field) => {
      const value = parseInt(field.value, 10) || 0;
      total += value;
    });

    totalField.value = total;
  }

  // Attach event listeners to each number input field
  page.querySelectorAll('input[type="number"]').forEach((field) => {
    field.addEventListener("input", updateTotal);
  });

  // Initial total calculation
  updateTotal();
}

// Initialize total calculation for each page in each form
document.addEventListener("DOMContentLoaded", function () {
  document
    .querySelectorAll(".jury-voting-form .form-page")
    .forEach(setupTotalCalculationForPage);
});
