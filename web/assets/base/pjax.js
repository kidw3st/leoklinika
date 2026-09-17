var Pjax = (function () {
  'use strict';

  /**
   * Lazy Session History API
   * ===
   * Access the associated data of a history entry even after user navigations.
   *
   * On page navigation events (like popstate), `window.history.state` has already been changed and
   * we can't update the previous state anymore. To leave a last mark on the leaving page, we have to
   * either keep updating the state continuously - which usually causes performance issues,
   * or make use of other API.
   *
   * Internally, this module uses **session storage** to store data, and uses browsers' original
   * history state as keys to identify session storage items.
   */

  /**
   * A valid history state object.
   */
  class LazyHistory {
    /**
     * The index of current state.
     */

    /**
     * The key used in `window.history.state` and session storage.
     */

    /**
     * The current state.
     */
    constructor(key) {
      this.key = key;
      this.pull();
    }
    /**
     * Keep up with current browser history entry.
     */


    pull() {
      // Get new state index.
      const historyState = window.history.state;
      const pulledIndex = historyState == null ? void 0 : historyState[this.key]; // Return if up-to-date.

      if (pulledIndex !== undefined && this.index === pulledIndex) return; // Get stored states.

      const stateListStr = window.sessionStorage.getItem(this.key);
      const stateList = stateListStr ? JSON.parse(stateListStr) : []; // Store current state.

      stateList[this.index] = this.state;
      window.sessionStorage.setItem(this.key, JSON.stringify(stateList));

      if (pulledIndex === undefined) {
        this.index = stateList.length;
        this.state = null;
        window.history.replaceState({ ...historyState,
          [this.key]: this.index
        }, document.title);
      } else {
        this.index = pulledIndex;
        this.state = stateListStr ? stateList[pulledIndex] : null;
      }
    }

  }

  /**
   * Replace HTML contents by using innerHTML.
   */
  const innerHTML = (oldNode, newNode) => {
    // eslint-disable-next-line no-param-reassign
    oldNode.innerHTML = newNode.innerHTML;
  };
  /**
   * Replace all text by using textContent.
   */


  const textContent = (oldNode, newNode) => {
    // eslint-disable-next-line no-param-reassign
    oldNode.textContent = newNode.textContent;
  };
  /**
   * Replace readable text by using innerText.
   */


  const innerText = (oldEle, newEle) => {
    // eslint-disable-next-line no-param-reassign
    oldEle.innerText = newEle.innerText;
  };
  /**
   * Rewrite all attributes.
   */


  const attributes = (oldEle, newEle) => {
    let existingNames = oldEle.getAttributeNames();
    const targetNames = newEle.getAttributeNames();
    targetNames.forEach(target => {
      oldEle.setAttribute(target, newEle.getAttribute(target) || '');
      existingNames = existingNames.filter(existing => existing !== target);
    });
    existingNames.forEach(existing => {
      oldEle.removeAttribute(existing);
    });
  };
  /**
   * Replace the whole element by using replaceWith.
   */


  const replaceWith = (oldNode, newNode) => {
    oldNode.replaceWith(newNode);
  };

  const Switches = {
    default: replaceWith,
    innerHTML,
    textContent,
    innerText,
    attributes,
    replaceWith
  };

  const capitalize = str => `${str.charAt(0).toUpperCase()}${str.slice(1)}`;

  class Submission {
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
      const {
        submitButton,
        form
      } = this;
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
      const {
        form,
        submitButton
      } = this;
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
      return Array.from(this.getEntryList(), ([key, value]) => [key, value instanceof File ? value.name : value]);
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
      return this.getNameValuePairs().reduce((str, [key, value]) => `${str}${key}=${value}\r\n`, '');
    }
    /**
     * Get the request to be sent by this submission.
     * @see [Form submission algorithm | HTML Standard]{@link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#form-submission-algorithm}
     */


    getRequestInfo() {
      const action = this.getAttribute('action');
      const actionURL = new URL(action, document.baseURI); // Only 'http' and 'https' schemes are supported.

      if (!/^https?:$/.test(actionURL.protocol)) return null;

      switch (this.getAttribute('method')) {
        /**
         * Mutate action URL.
         * @see [Mutate action URL | HTML Standard]{@link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#submit-mutate-action}
         */
        case 'get':
          {
            actionURL.search = this.getURLSearchParams().toString();
            return actionURL.href;
          }

        /**
         * Submit as entity body.
         * @see [Submit as entity body | HTML Standard]{@link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#submit-body}
         */

        case 'post':
          {
            let body;

            switch (this.getAttribute('enctype')) {
              case 'application/x-www-form-urlencoded':
                body = this.getURLSearchParams();
                break;

              case 'multipart/form-data':
                body = this.getEntryList();
                break;

              case 'text/plain':
                body = this.getTextPlain();
                break;

              default:
                return null;
            }

            return new Request(action, {
              method: 'POST',
              body
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

  /**
   * Get the target browsing context chosen by anchors or forms
   * @see [The rules for choosing a browsing context | HTML Standard]{@link https://html.spec.whatwg.org/multipage/browsers.html#the-rules-for-choosing-a-browsing-context-given-a-browsing-context-name}
   */
  const getBrowsingContext = target => {
    if (target === window.name) return window;

    switch (target.toLowerCase()) {
      case '':
      case '_self':
        return window;

      case '_parent':
        return window.parent;

      case '_top':
        return window.top;

      default:
        return undefined;
    }
  };

  class DefaultTrigger {
    constructor(pjax) {
      this.pjax = pjax;
    }
    /**
     * Check if the current trigger options apply to the element.
     */


    test(element) {
      const {
        defaultTrigger
      } = this.pjax.options;
      if (typeof defaultTrigger === 'boolean') return defaultTrigger;
      const {
        enable,
        exclude
      } = defaultTrigger;
      return enable !== false && (!exclude || !element.matches(exclude));
    }
    /**
     * Load a resource with element attribute support.
     * @see [Follow the hyperlink | HTML Standard]{@link https://html.spec.whatwg.org/multipage/links.html#following-hyperlinks-2}
     * @see [Plan to navigate | HTML Standard]{@link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#plan-to-navigate}
     */


    load(resource, subject) {
      var _subject$getAttribute, _subject$getAttribute2;

      /**
       * The RequestInit to align the request to send by the element.
       */
      const requestInit = {};
      /**
       * Referrer policy that specified on the element.
       * Will cause a TypeError in the later Request constructing step if the attribute is invalid.
       * Not bypassing forms here as it is supposed to be supported in the future.
       * @see [Add referrerpolicy to &lt;form&gt; · whatwg/html]{@link https://github.com/whatwg/html/issues/4320}
       */

      const referrerPolicy = (_subject$getAttribute = subject.getAttribute('referrerpolicy')) == null ? void 0 : _subject$getAttribute.toLowerCase();
      if (referrerPolicy !== undefined) requestInit.referrerPolicy = referrerPolicy;
      /**
       * Use no referrer if specified in the link types.
       * Not reading from `.relList` here as browsers haven't shipped it for forms yet.
       * @see [Add &lt;form rel&gt; initial compat data · mdn/browser-compat-data]{@link https://github.com/mdn/browser-compat-data/pull/9130}
       */

      if ((_subject$getAttribute2 = subject.getAttribute('rel')) != null && _subject$getAttribute2.split(/\s+/).some(type => type.toLowerCase() === 'noreferrer')) {
        requestInit.referrer = '';
      }

      this.pjax.load(new Request(resource, requestInit)).catch(() => {});
    }

    onLinkOpen(event) {
      if (event.defaultPrevented) return;
      const {
        target
      } = event;
      if (!(target instanceof Element)) return;
      const link = target.closest('a[href], area[href]');
      if (!link) return;
      if (!this.test(link)) return;

      if (event instanceof MouseEvent || event instanceof KeyboardEvent) {
        if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
      }

      if (getBrowsingContext(link.target) !== window) return; // External.

      if (link.origin !== window.location.origin) return;
      event.preventDefault();
      this.load(link.href, link);
    }

    onFormSubmit(event) {
      if (event.defaultPrevented) return;
      const {
        target: form,
        submitter
      } = event;
      if (!(form instanceof HTMLFormElement)) return;
      if (!this.test(form)) return;
      const submission = new Submission(form, submitter);
      if (getBrowsingContext(submission.getAttribute('target')) !== window) return;
      const requestInfo = submission.getRequestInfo();
      if (!requestInfo) return;
      const url = new URL(typeof requestInfo === 'string' ? requestInfo : requestInfo.url); // External.

      if (url.origin !== window.location.origin) return;
      event.preventDefault();
      this.load(requestInfo, form);
    }

    register() {
      document.addEventListener('click', event => {
        this.onLinkOpen(event);
      });
      document.addEventListener('keyup', event => {
        if (event.key !== 'Enter') return;
        this.onLinkOpen(event);
      }); // Lacking browser compatibility and small polyfill. - August 2, 2021

      if ('SubmitEvent' in window) {
        document.addEventListener('submit', event => {
          this.onFormSubmit(event);
        });
      }
    }

  }

  async function switchNodes(sourceDocument, {
    selectors,
    switches,
    signal = null
  }) {
    if (signal != null && signal.aborted) throw new DOMException('Aborted switches', 'AbortError');
    let focusCleared = false;
    const switchPromises = [];
    selectors.forEach(selector => {
      const sourceNodeList = sourceDocument.querySelectorAll(selector);
      const targetNodeList = document.querySelectorAll(selector); // Throw when the structure is not match.

      if (sourceNodeList.length !== targetNodeList.length) {
        throw new DOMException(`Selector '${selector}' does not select the same amount of nodes`, 'IndexSizeError');
      }

      const {
        activeElement
      } = document; // Start switching for each match.

      targetNodeList.forEach((targetNode, index) => {
        // Clear out focused controls before switching.
        if (!focusCleared && activeElement && targetNode.contains(activeElement)) {
          if (activeElement instanceof HTMLElement || activeElement instanceof SVGElement) {
            activeElement.blur();
          }

          focusCleared = true;
        } // Argument defined switch is prior to default switch.


        const targetSwitch = (switches == null ? void 0 : switches[selector]) || Switches.default; // Start switching. Package to promise. Ignore switch errors.

        const switchPromise = Promise.resolve().then(() => targetSwitch(targetNode, sourceNodeList[index])).catch(() => {});
        switchPromises.push(switchPromise);
      });
    }); // Reject as soon as possible on abort.

    await Promise.race([Promise.all(switchPromises), new Promise((resolve, reject) => {
      signal == null ? void 0 : signal.addEventListener('abort', () => {
        reject(new DOMException('Aborted switches', 'AbortError'));
      });
    })]);
    return {
      focusCleared
    };
  }

  async function switchDOM(requestInfo, overrideOptions = {}) {
    var _this$abortController, _hooks$request;

    const {
      selectors,
      switches,
      cache,
      timeout,
      hooks
    } = { ...this.options,
      ...overrideOptions
    };
    const eventDetail = {};
    const signal = ((_this$abortController = this.abortController) == null ? void 0 : _this$abortController.signal) || null;
    eventDetail.signal = signal;
    /**
     * Specify request cache mode and abort signal.
     */

    const requestInit = {
      cache,
      signal
    };
    /**
     * Specify original referrer and referrerPolicy
     * since the later Request constructor steps discard the original ones.
     * @see [Request constructor steps | Fetch Standard]{@link https://fetch.spec.whatwg.org/#dom-request}
     */

    if (requestInfo instanceof Request) {
      requestInit.referrer = requestInfo.referrer;
      requestInit.referrerPolicy = requestInfo.referrerPolicy;
    }

    const rawRequest = new Request(requestInfo, requestInit);
    rawRequest.headers.set('X-Requested-With', 'Fetch');
    rawRequest.headers.set('X-Pjax', 'true');
    rawRequest.headers.set('X-Pjax-Selectors', JSON.stringify(selectors));
    const request = (await ((_hooks$request = hooks.request) == null ? void 0 : _hooks$request.call(hooks, rawRequest))) || rawRequest;
    eventDetail.request = request; // Set timeout.

    eventDetail.timeout = timeout;
    let timeoutID;

    if (timeout > 0) {
      timeoutID = window.setTimeout(() => {
        var _this$abortController2;

        (_this$abortController2 = this.abortController) == null ? void 0 : _this$abortController2.abort();
      }, timeout);
      eventDetail.timeoutID = timeoutID;
    }

    this.fire('send', eventDetail);

    try {
      var _hooks$response, _hooks$document, _hooks$switchesResult;

      const rawResponse = await fetch(request).finally(() => {
        window.clearTimeout(timeoutID);
      });
      const response = (await ((_hooks$response = hooks.response) == null ? void 0 : _hooks$response.call(hooks, rawResponse))) || rawResponse;
      eventDetail.response = response;
      this.fire('receive', eventDetail); // Push history state. Preserve hash as the fetch discards it.

      const newLocation = new URL(response.url);
      newLocation.hash = new URL(request.url).hash;

      if (window.location.href !== newLocation.href) {
        window.history.pushState(null, '', newLocation.href);
      } // Switch elements.


      const rawDocument = new DOMParser().parseFromString(await response.text(), 'text/html');
      const document = (await ((_hooks$document = hooks.document) == null ? void 0 : _hooks$document.call(hooks, rawDocument))) || rawDocument;
      eventDetail.switches = switches;
      const rawSwitchesResult = await switchNodes(document, {
        selectors,
        switches,
        signal
      });
      const switchesResult = (await ((_hooks$switchesResult = hooks.switchesResult) == null ? void 0 : _hooks$switchesResult.call(hooks, rawSwitchesResult))) || rawSwitchesResult;
      eventDetail.switchesResult = switchesResult; // Simulate initial page load.

      await this.preparePage(switchesResult, overrideOptions);
    } catch (error) {
      eventDetail.error = error;
      this.fire('error', eventDetail);
      throw error;
    } finally {
      this.fire('complete', eventDetail);
    }

    this.fire('success', eventDetail);
  }

  /**
   * Follow
   * https://html.spec.whatwg.org/multipage/scripting.html#prepare-a-script
   * excluding steps concerning obsoleted attributes.
   */

  /**
   * Regex for JavaScript MIME type strings.
   * @see [JavaScript MIME type | MIME Sniffing Standard]{@link https://mimesniff.spec.whatwg.org/#javascript-mime-type}
   */
  const MIMETypeRegex = /^((application|text)\/(x-)?(ecma|java)script|text\/(javascript1\.[0-5]|(j|live)script))$/;
  class Script {
    constructor(scriptEle) {
      this.external = false;
      this.blocking = false;
      this.evaluable = false;
      this.target = scriptEle; // Process empty.

      if (!scriptEle.hasAttribute('src') && !scriptEle.text) return; // Process type.

      const typeString = scriptEle.type ? scriptEle.type.trim().toLowerCase() : 'text/javascript';

      if (MIMETypeRegex.test(typeString)) {
        this.type = 'classic';
      } else if (typeString === 'module') {
        this.type = 'module';
      } else {
        return;
      } // Process no module.


      if (scriptEle.noModule && this.type === 'classic') {
        return;
      } // Process external.


      if (scriptEle.src) {
        this.external = true;
      } // Process blocking.
      // It's minifier plugins' job to merge conditions. We split them out for readability.


      this.blocking = true;

      if (this.type !== 'classic') {
        this.blocking = false;
      } else if (this.external) {
        /**
         * The async IDL attribute may not reflect the async content attribute.
         * @see [The async IDL attribute | HTML Standard]{@link https://html.spec.whatwg.org/multipage/scripting.html#dom-script-async}
         */
        if (scriptEle.hasAttribute('async')) {
          this.blocking = false;
        } else if (scriptEle.defer) {
          this.blocking = false;
        }
      }

      this.evaluable = true;
    }

    eval() {
      return new Promise((resolve, reject) => {
        const oldEle = this.target;
        const newEle = document.createElement('script');
        newEle.addEventListener('error', reject);
        /**
         * Clone attributes and inner text.
         * Reset async since it defaults to true on dynamically created scripts.
         */

        newEle.async = false;
        oldEle.getAttributeNames().forEach(name => {
          newEle.setAttribute(name, oldEle.getAttribute(name) || '');
        });
        newEle.text = oldEle.text;
        /**
         * Execute.
         * Not using `.isConnected` here as it is also `true`
         * for scripts connected in other documents.
         */

        if (document.contains(oldEle)) {
          oldEle.replaceWith(newEle);
        } else {
          // Execute in <head> if it's not in current document.
          document.head.append(newEle);

          if (this.external) {
            newEle.addEventListener('load', () => newEle.remove());
          } else {
            newEle.remove();
          }
        }

        if (this.external) {
          newEle.addEventListener('load', () => resolve());
        } else {
          resolve();
        }
      });
    }

  }

  class Executor {
    constructor(signal) {
      this.signal = signal;
    }
    /**
     * Execute script.
     * Throw only when aborted.
     * Wait only for blocking script.
     */


    async exec(script) {
      var _this$signal;

      if ((_this$signal = this.signal) != null && _this$signal.aborted) throw new DOMException('Execution aborted', 'AbortError');
      const evalPromise = script.eval().catch(() => {});
      if (script.blocking) await evalPromise;
    }

  }
  /**
   * Find and execute scripts in order.
   * Needed since innerHTML does not run scripts.
   */


  async function executeScripts(scriptEleList, {
    signal = null
  } = {}) {
    if (signal != null && signal.aborted) throw new DOMException('Aborted execution', 'AbortError');
    const validScripts = Array.from(scriptEleList, scriptEle => new Script(scriptEle)).filter(script => script.evaluable);
    const executor = new Executor(signal); // Evaluate external scripts first
    // to help browsers fetch them in parallel.
    // Each inline blocking script will be evaluated as soon as
    // all its previous blocking scripts are executed.

    const execution = validScripts.reduce((promise, script) => {
      if (script.external) {
        return Promise.all([promise, executor.exec(script)]);
      }

      return promise.then(() => executor.exec(script));
    }, Promise.resolve()); // Reject as soon as possible on abort.

    await Promise.race([execution, new Promise((resolve, reject) => {
      signal == null ? void 0 : signal.addEventListener('abort', () => {
        reject(new DOMException('Aborted execution', 'AbortError'));
      });
    })]);
  }

  /**
   * Get the indicated part of the document.
   * Not using :target pseudo class here as it may not be updated by pushState.
   * @see [The indicated part of the document | HTML Standard]{@link https://html.spec.whatwg.org/multipage/browsing-the-web.html#the-indicated-part-of-the-document}
   */

  const getIndicatedPart = () => {
    let target = null;
    const hashId = decodeURIComponent(window.location.hash.slice(1));
    if (hashId) target = document.getElementById(hashId) || document.getElementsByName(hashId)[0];
    if (!target && (!hashId || hashId.toLowerCase() === 'top')) target = document.scrollingElement;
    return target;
  };
  /**
   * After page elements are updated.
   */


  async function preparePage(switchesResult, overrideOptions = {}) {
    const options = { ...this.options,
      ...overrideOptions
    }; // If page elements are switched.

    if (switchesResult) {
      var _this$abortController;

      // Focus the FIRST autofocus if the previous focus is cleared.
      // https://html.spec.whatwg.org/multipage/interaction.html#the-autofocus-attribute
      if (switchesResult.focusCleared) {
        const autofocus = document.querySelectorAll('[autofocus]')[0];

        if (autofocus instanceof HTMLElement || autofocus instanceof SVGElement) {
          autofocus.focus();
        }
      } // List newly added and labeled scripts.


      const scripts = [];

      if (options.scripts) {
        document.querySelectorAll(options.scripts).forEach(element => {
          if (element instanceof HTMLScriptElement) scripts.push(element);
        });
      }

      options.selectors.forEach(selector => {
        document.querySelectorAll(selector).forEach(element => {
          if (element instanceof HTMLScriptElement) {
            scripts.push(element);
          } else {
            element.querySelectorAll('script').forEach(script => {
              if (scripts.includes(script)) return;
              scripts.push(script);
            });
          }
        });
      }); // Sort in document order.
      // https://stackoverflow.com/a/22613028

      scripts.sort((a, b) => // Bitwise AND operator is required here.
      // eslint-disable-next-line no-bitwise
      a.compareDocumentPosition(b) & Node.DOCUMENT_POSITION_PRECEDING || -1); // Execute.

      await executeScripts(scripts, {
        signal: ((_this$abortController = this.abortController) == null ? void 0 : _this$abortController.signal) || null
      });
    } // Parse required scroll position.


    const {
      scrollTo
    } = options; // When scroll is allowed.

    if (scrollTo !== false) {
      // If switched, default to left top. Otherwise, default to no scroll.
      let parsedScrollTo = switchesResult ? [0, 0] : false;

      if (Array.isArray(scrollTo)) {
        parsedScrollTo = scrollTo;
      } else if (typeof scrollTo === 'number') {
        parsedScrollTo = [window.scrollX, scrollTo];
      } else {
        const target = getIndicatedPart();

        if (target) {
          target.scrollIntoView();
          parsedScrollTo = false;
        }
      } // Scroll.


      if (parsedScrollTo) window.scrollTo(parsedScrollTo[0], parsedScrollTo[1]);
    }
  }

  /**
   * Load a URL in Pjax way. Throw all errors.
   */
  async function weakLoad(requestInfo, overrideOptions = {}) {
    var _this$abortController;

    // Store scroll position.
    this.storeHistory(); // Setup abort controller.

    const abortController = new AbortController();
    (_this$abortController = this.abortController) == null ? void 0 : _this$abortController.abort();
    this.abortController = abortController;
    /**
     * The URL object of the target resource.
     * Used to identify fragment navigations.
     */

    const url = new URL(typeof requestInfo === 'string' ? requestInfo : requestInfo.url, document.baseURI);
    const path = url.pathname + url.search;
    const currentPath = this.location.pathname + this.location.search;
    /**
     * Identify fragment navigations.
     * Not using `.hash` here as it becomes the empty string for both empty and null fragment.
     * @see [Navigate fragment step | HTML Standard]{@link https://html.spec.whatwg.org/multipage/browsing-the-web.html#navigate-fragid-step}
     * @see [URL hash getter | URL Standard]{@link https://url.spec.whatwg.org/#dom-url-hash}
     */

    if (path === currentPath && url.href.includes('#')) {
      // pushState on different hash.
      if (window.location.hash !== url.hash) {
        window.history.pushState(null, '', url.href);
      } // Directly prepare for fragment navigation.


      await this.preparePage(null, overrideOptions);
    } else {
      // Switch DOM for normal navigation.
      await this.switchDOM(requestInfo, overrideOptions);
    } // Update Pjax location and prepare the page.


    this.history.pull();
    this.location.href = window.location.href; // Finish, remove abort controller.

    this.abortController = null;
  }

  class Pjax {
    static reload() {
      window.location.reload();
    }
    /**
     * Options default values.
     */


    constructor(options = {}) {
      this.options = {
        defaultTrigger: true,
        selectors: ['title', '.pjax'],
        switches: {},
        scripts: 'script[data-pjax]',
        scrollTo: true,
        scrollRestoration: true,
        cache: 'default',
        timeout: 0,
        hooks: {}
      };
      this.history = new LazyHistory('pjax');
      this.location = new URL(window.location.href);
      this.abortController = null;
      this.switchDOM = switchDOM;
      this.preparePage = preparePage;
      this.weakLoad = weakLoad;
      Object.assign(this.options, options);

      if (this.options.scrollRestoration) {
        window.history.scrollRestoration = 'manual'; // Browsers' own restoration is faster and more stable on reload.

        window.addEventListener('beforeunload', () => {
          window.history.scrollRestoration = 'auto';
        });
      }

      const {
        defaultTrigger
      } = this.options;

      if (defaultTrigger === true || defaultTrigger !== false && defaultTrigger.enable !== false) {
        new DefaultTrigger(this).register();
      }

      window.addEventListener('popstate', event => {
        /**
         * The main reason why we write the LazyHistory library is right here:
         * `window.history.state` is ALREADY changed on popstate events and
         * we can't update the previous state anymore. (For scroll position, etc.)
         * As continuously updating `window.history.state` causes performance issues,
         * using a custom library seems to be the only choice.
         */
        // Store scroll position and then update the lazy state.
        this.storeHistory();
        this.history.pull(); // hashchange events trigger popstate with a null `event.state`.

        if (event.state === null) return;
        const overrideOptions = {};

        if (this.options.scrollRestoration && this.history.state) {
          overrideOptions.scrollTo = this.history.state.scrollPos;
        }

        this.load(window.location.href, overrideOptions).catch(() => {});
      });
    }

    storeHistory() {
      this.history.state = {
        scrollPos: [window.scrollX, window.scrollY]
      };
    }
    /**
     * Fire Pjax related events.
     */


    fire(type, detail) {
      const event = new CustomEvent(`pjax:${type}`, {
        bubbles: true,
        cancelable: false,
        detail: {
          abortController: this.abortController,
          ...detail
        }
      });
      document.dispatchEvent(event);
    }

    /**
     * Load a URL in Pjax way. Navigate normally on errors except AbortError.
     */
    async load(requestInfo, overrideOptions = {}) {
      try {
        await this.weakLoad(requestInfo, overrideOptions);
      } catch (e) {
        if (e instanceof DOMException && e.name === 'AbortError') throw e;
        window.location.assign(typeof requestInfo === 'string' ? requestInfo : requestInfo.url);
      }
    }

  }

  Pjax.switches = Switches;

  return Pjax;

})();
//# sourceMappingURL=pjax.js.map
