document.addEventListener("change", function (e) {
  if (e.target.matches("[data-autosubmit]")) {
    var form = e.target.closest("form");

    var command = e.target.getAttribute("data-autosubmit");
    if (command == "") command = "autosubmit";
    var command_input = form.querySelector("[name=command][type=hidden]");
    if (!command_input) {
      command_input = document.createElement("input");
      command_input.name = "command";
      command_input.type = "hidden";
      form.prepend(command_input);
    }
    command_input.value = command;

    form.noValidate = true;
    form.requestSubmit();

    var inputs = form.querySelectorAll("input");
    if (inputs.length) {
      inputs.forEach(function (el, idx) {
        el.setAttribute("readonly", "readonly");
      });
    }
  }
});

document.addEventListener("click", function (e) {
  if (e.target.matches("[data-autosubmit]")) {
    var form = e.target.closest("form");

    var command = e.target.getAttribute("data-autosubmit");
    if (command == "") command = "autosubmit";
    var command_input = form.querySelector("[name=command][type=hidden]");
    if (!command_input) {
      command_input = document.createElement("input");
      command_input.name = "command";
      command_input.type = "hidden";
      form.prepend(command_input);
    }
    command_input.value = command;

    form.noValidate = true;
    //form.requestSubmit();
  }

  if (e.target.closest(".search-block__form__btn_close")) {
      document.querySelectorAll("input[name=search]").forEach((e => {
        setTimeout((() => {e.value = ""; e.closest("form").requestSubmit();}), 100)
      }))
  }
});

document.addEventListener("submit", function (e) {
  if (e.target.dataset.disabled == 1) {
    e.preventDefault();
    e.stopImmediatePropagation();
    return false;
  }

  //e.target.dataset.disabled = 1;

  return true;
});

function show_success_modal(text) {
  document.querySelector("#review-success .text").innerHTML = text;
  document.querySelector(".success_button").click();
}

function switch_active() {
    document.querySelectorAll(".switch").forEach((e => {
            const t = e.querySelectorAll(".switch__text")
            , s = e.querySelector("input");
    t[0].addEventListener("click", ( () => {
            s.value = t[1].dataset.value,
        s.checked = !1,
        t[1].classList.remove("_active"),
        t[0].classList.add("_active")
}
)),
    t[1].addEventListener("click", ( () => {
            s.value = t[1].dataset.value,
        s.checked = !0,
        t[0].classList.remove("_active"),
        t[1].classList.add("_active")
}
)),
    s.addEventListener("click", (e => {
        e.target.checked ? (s.value = t[1].dataset.value,
            t[0].classList.remove("_active"),
            t[1].classList.add("_active")) : (s.value = t[0].dataset.value,
            t[1].classList.remove("_active"),
            t[0].classList.add("_active"))
}
))
}
))
}