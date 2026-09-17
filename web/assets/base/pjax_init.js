var pjax = new Pjax({
  selectors: [],
  scrollTo: false,
  defaultTrigger: false,
  switches: {},
});

document.addEventListener("submit", function (e) {
  if (e.target.hasAttribute("data-pjax-block")) {
    e.preventDefault();

    var submission = new Submission_copy(e.target, e.submitter);

    pjax_send(
      e.target.getAttribute("data-pjax-block"),
      submission.getRequestInfo()
    );
  }
});

document.addEventListener("click", function (e) {
    if (e.target.tagName == 'A' && e.target.hasAttribute("data-pjax-block")) {
        e.preventDefault();

        pjax_send(e.target.getAttribute("data-pjax-block"), e.target.href);
    }
});

/*var focused_input = false;
document.addEventListener('pjax:receive', function () {
    focused_input = document.querySelector('input:focus');
    if (focused_input) {
        var hidden_input = document.createElement('div');
        hidden_input.id = 'hidden_input';
        hidden_input.style = 'display: none';
        document.body.appendChild(hidden_input);
        hidden_input.appendChild(focused_input);
    }
});

document.addEventListener('pjax:success', function () {
    if (focused_input) {
        var old_element = document.querySelector('[name="'+focused_input.name+'"]');
        if (old_element) {
            old_element.parentNode.replaceChild(focused_input, old_element);
            focused_input.focus();
        }
        document.querySelector('#hidden_input').remove();
    }
});*/

var focused_input_name = false;
document.addEventListener("pjax:receive", function () {
  focused_input_name = false;
  var focused_input = document.querySelector("input:focus");
  if (focused_input) {
    focused_input_name = focused_input.name;
  }
});

document.addEventListener("pjax:complete", function () {
  if (focused_input_name) {
    var focused_input = document.querySelector(
      '[name="' + focused_input_name + '"]'
    );
    if (focused_input) {
      focused_input.focus();
    }
  }

    window.doctorsThinSwiper();
    window.doctorsWideSwiper();
    switch_active();
  //window.__formInit();
});

function pjax_send(selector, request) {
  pjax.options["selectors"] = [selector];
  //pjax.options['switches'] = {};
  //pjax.options['switches'][selector] = Pjax.switches.replaceWith;
  pjax.load(request);
}

class Submission_copy {
  /**
   * Parse the basic facilities that will be frequently used in the submission.
   * @see [Form submission algorithm | HTML Standard]{@link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#form-submission-algorithm}
   */
  constructor(form, submitter) {
    this.form = form;
    this.submitButton = submitter;
  }
  /**
   * Parse submission related content attributes.
   * @see [Form submission attributes | HTML Standard]{@link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#form-submission-attributes}
   */

  getAttribute(name) {
    const { submitButton, form } = this;
    /**
     * Some attributes from the submit button override the form's one.
     * Before reading the IDL value, do a hasAttribute check since the IDL may return
     * a value (usually the default) even when the related content attribute is not present.
     */

    if (submitButton && submitButton.hasAttribute(`form${name}`)) {
      const overrideValue = submitButton[`form${capitalize(name)}`];
      if (overrideValue) return overrideValue;
    }

    return form[name];
  }
  /**
   * Construct the entry list and return in FormData format.
   * Manually append submitter entry before we can directly specify the submitter button.
   * The manual way has the limitation that the submitter entry always comes last.
   * @see [Constructing the entry list | HTML Standard]{@link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#constructing-form-data-set}
   * @see [FormData: Add ability to specify submitter in addition to &lt;form&gt; · whatwg/xhr]{@link https://github.com/whatwg/xhr/issues/262}
   */

  getEntryList() {
    const { form, submitButton } = this;
    const formData = new FormData(form);

    if (submitButton && !submitButton.disabled && submitButton.name) {
      formData.append(submitButton.name, submitButton.value);
    }

    return formData;
  }
  /**
   * The application/x-www-form-urlencoded and text/plain encoding algorithms
   * take a list of name-value pairs, where the values must be strings,
   * rather than an entry list where the value can be a File.
   * @see [Converting an entry list to a list of name-value pairs | HTML Standard]{@link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#converting-an-entry-list-to-a-list-of-name-value-pairs}
   */

  getNameValuePairs() {
    return Array.from(this.getEntryList(), ([key, value]) => [
      key,
      value instanceof File ? value.name : value,
    ]);
  }
  /**
   * URLSearchParams is a native API that
   * uses the application/x-www-form-urlencoded format and encoding algorithm.
   * @see [URLSearchParams class | URL Standard]{@link https://url.spec.whatwg.org/#interface-urlsearchparams}
   */

  getURLSearchParams() {
    return new URLSearchParams(this.getNameValuePairs());
  }
  /**
   * text/plain encoding algorithm for plain text form data.
   * @see [text/plain encoding algorithm | HTML Standard]{@link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#text/plain-encoding-algorithm}
   */

  getTextPlain() {
    return this.getNameValuePairs().reduce(
      (str, [key, value]) => `${str}${key}=${value}\r\n`,
      ""
    );
  }
  /**
   * Get the request to be sent by this submission.
   * @see [Form submission algorithm | HTML Standard]{@link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#form-submission-algorithm}
   */

  getRequestInfo() {
    const action = this.getAttribute("action");
    const actionURL = new URL(action, document.baseURI); // Only 'http' and 'https' schemes are supported.

    if (!/^https?:$/.test(actionURL.protocol)) return null;

    switch (this.getAttribute("method")) {
      /**
       * Mutate action URL.
       * @see [Mutate action URL | HTML Standard]{@link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#submit-mutate-action}
       */
      case "get": {
        actionURL.search = this.getURLSearchParams().toString();
        return actionURL.href;
      }

      /**
       * Submit as entity body.
       * @see [Submit as entity body | HTML Standard]{@link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#submit-body}
       */

      case "post": {
        let body;

        switch (this.getAttribute("enctype")) {
          case "application/x-www-form-urlencoded":
            body = this.getURLSearchParams();
            break;

          case "multipart/form-data":
            body = this.getEntryList();
            break;

          case "text/plain":
            body = this.getTextPlain();
            break;

          default:
            return null;
        }

        return new Request(action, {
          method: "POST",
          body,
        });
      }

      /**
       * Method with no request to send ('dialog' method) or unsupported.
       */

      default:
        return null;
    }
  }
}
