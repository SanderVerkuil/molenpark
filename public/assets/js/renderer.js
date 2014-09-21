var Renderer = function()
{
  var exports = {};

  var options = {
    renderContext: $("body"),
    loadingContext: $("body"),
    templateUrl: undefined,
    dataUrl: undefined,
    dataObj: undefined,
    complete: function() {
    },
    append: true,
    removeUnmatched: false
  }

  function renderCollection(opts)
  {
    $.extend(options, opts);

    var obj = options.dataObj != undefined;
    var url = options.dataUrl != undefined;

    var t = obj ? !url : url;

    if (!t)
    {
      throw "Either obj or url must be defined, but not both.";
    }

    $.ajax({
      url: opts.templateUrl,
      success: function(template) {
        if (obj) {
          var output = "";
          $.each(options.dataObj, function(key, value) {
            output += render(template, value);
          });
          completeRendering(output);
        } else {
         $.ajax({
          url: options.dataUrl,
          success: function(data) {
            var output = "";
            $.each(data, function(key, value) {
              output += render(template, value);
            });
            completeRendering(output);
          },
          dataType: "json"
         })
        }
      }
    })


  }
  exports.renderCollection = renderCollection;

  function completeRendering(output) {
    if (options.append) {
      options.renderContext.append(output);
    } else {
      options.renderContext.html(output);
    }

    options.complete($(output), options.renderContext);
  }

  function renderPage(opts)
  {

    $.extend(options, opts);

    var obj = options.dataObj != undefined;
    var url = options.dataUrl != undefined;

    var t = obj ? !url : url;

    if (!t)
    {
      throw "Either obj or url must be defined, but not both.";
    }

    $.ajax({
      url: opts.templateUrl,
      success: function(template) {
        if (obj) {
          completeRendering(render(template, options.dataObj));
        } else {
          $.ajax({
            url: opts.dataUrl,
            success: function(data) {
              completeRendering(render(template, data));
            },
            dataType: "json"
          })
        }
      }
    })
  }
  exports.renderPage = renderPage;

  function render(template, data)
  {
    output = template;

    output = output.replace(/{{base_url}}/ig, base_url)


    output = RenderSections(output, data);
    output = RenderVariables(output, data);
    if (options.removeUnmatched) {
      output = output.replace(/{{(.*?)}}/ig, "")
    }

    return output;
  }

  function RenderVariables(template, data)
  {
    $.each(data, function(key, value)
    {
      var regex = new RegExp("{{" + key + "}}", "ig");

      if (typeof value == 'function')
      {
        template = template.replace(regex, value(data));
      } else {
        template = template.replace(regex, value);
      }
    });

    return template;
  }

  function RenderSections(template, data)
  {
    $.each(data, function(key, value) {
      var markupRegex = new RegExp("{{#" + key + "}}((.|\n)*?){{\\/" + key + "}}", "ig");
      var hiddenRegex = new RegExp("{{\\^" + key + "}}((.|\n)*?){{\\/" + key + "}}", "ig");

      var markupMatch = markupRegex.exec(template);
      var hiddenMatch = hiddenRegex.exec(template);
      var markupOutput = "";
      var hiddenOutput = "";

      if (markupMatch != null)
      {
        switch(typeof value) {
          case "boolean":
            if (value) {
              markupOutput = markupMatch[1];
            }
          break;
          case "function":
            if (value(data)) {
              markupOutput = markupMatch[1];
            }
          break;
          default:
            var to = "";

            $.each(value, function(k, v) {
              switch(typeof v) {
                case "string":
                  to += markupMatch[1].replace(/{{\.}}/ig, v);
                break;
                default:
                  var t = RenderSections(markupMatch[1], v);
                  to += RenderVariables(t, v);
                break;
              }
            })

            if (to == "") {
              if (hiddenMatch != null)
                to = hiddenMatch[1];
            }

            markupOutput += to;

          break;
        }
      }

      template = template.replace(markupRegex, markupOutput);
      template = template.replace(hiddenRegex, hiddenOutput);

    })
    return template;
  }

  function init()
  {

  }
  exports.init = init;

  return exports;
}
