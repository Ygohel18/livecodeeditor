function compile() {
  var code = document.getElementById("code").contentWindow.document;

  var htmlCode = CodeMirror(document.querySelector(".main .code .html-code"), {
    mode: "xml",
    theme: "dracula",
    lineNumbers: true,
  });

  var cssCode = CodeMirror(document.querySelector(".main .code .css-code"), {
    mode: "css",
    theme: "dracula",
    lineNumbers: true,
  });

  var jsCode = CodeMirror(document.querySelector(".main .code .js-code"), {
    mode: "javascript",
    theme: "dracula",
    lineNumbers: true,
  });

  let id = getUrlParameter("id");

  if (id != null) {
    localStorage.setItem("pid", id);
    let path = "http://localhost/code/code/" + id + ".json";
    $.getJSON(path, function (data) {
      localStorage.setItem("code_html", JSON.stringify(data.code.html));
      localStorage.setItem("code_css", JSON.stringify(data.code.css));
      localStorage.setItem("code_js", JSON.stringify(data.code.js));
      htmlCode.setValue(JSON.parse(data.code.html));
      cssCode.setValue(JSON.parse(data.code.css));
      jsCode.setValue(JSON.parse(data.code.js));

    }).fail(function () {
      console.log("An error has occurred.");
    });
  } else {
    localStorage.setItem("pid", null);
  }

  var btn_html = document.getElementById("btn_html");
  var btn_css = document.getElementById("btn_css");
  var btn_js = document.getElementById("btn_js");

  var html = document.getElementById("html_code");
  var css = document.getElementById("css_code");
  var js = document.getElementById("js_code");

  var css_lable = document.getElementById("lable_css");
  var js_lable = document.getElementById("lable_js");

  btn_html.addEventListener("click", function () {
    html.style.display = "block";
    css.style.display = "none";
    js.style.display = "none";
  });

  btn_css.addEventListener("click", function () {
    html.style.display = "none";
    css.style.display = "block";
    css.style.width = "100%";
    css_lable.style.display = "none";
    document.querySelector(
      ".CodeMirror-cursors .CodeMirror-cursor"
    ).style.left = "40px !important";
    js.style.display = "none";
  });

  btn_js.addEventListener("click", function () {
    html.style.display = "none";
    css.style.display = "none";
    js.style.display = "block";
    js.style.width = "100%";
    js_lable.style.display = "none";
  });

  document.addEventListener("keydown", function (e) {
    if (e.ctrlKey && e.which === 83) {
      // Check for the Ctrl key being pressed, and if the key = [S] (83)
      saveCode();
      e.preventDefault();
      return false;
    }
  });

  // document.body.onkeyup = function () {
  //   code.open();
  //   code.writeln(
  //     htmlCode.getValue() +
  //       "<style>" +
  //       cssCode.getValue() +
  //       "</style>" +
  //       "<script>" +
  //       jsCode.getValue() +
  //       "</script>"
  //   );
  //   code.close();
  // };

  let save = document.getElementById("save_code");
  function saveCode() {
    localStorage.setItem("code_html", JSON.stringify(htmlCode.getValue()));
    localStorage.setItem("code_css", JSON.stringify(cssCode.getValue()));
    localStorage.setItem("code_js", JSON.stringify(jsCode.getValue()));

    console.clear();
    code.open();
    code.writeln(
      htmlCode.getValue() +
      "<style>" +
      cssCode.getValue() +
      "</style>" +
      "<script>" +
      jsCode.getValue() +
      "</script>"
    );
    code.close();
  }
  save.addEventListener("click", saveCode());
}

window.onload = function () {

  let isLogin = localStorage.getItem("isLogin");

  if (isLogin == "false") {

    window.location = "./login.html";
  } else {
    compile();
    console.clear();
  }

};

function getUrlParameter(k) {
  var p = {};
  location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (s, k, v) {
    p[k] = v;
  });
  return k ? p[k] : p;
}
