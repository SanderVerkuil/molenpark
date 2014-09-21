var Pagination = function()
{
  var exports = {};

  var options = {
    paginationContext: $("body"),
    resultsContext: $("body"),
    headerContext: $("body"),
    loadingContext: $("body"),
    perPage: 6,
    searchUrl: undefined,
    renderer: undefined,
    offsetLeft: 4,
    offsetRight: 4,
    totalWidth: function() {
      return this.offsetLeft+1+this.offsetRight;
    },
    complete: function() {

    }
  }

  function showPagination(info, opts) {
    var _options = {
      curPage: 1,
      firstPage: 1,
      lastPage: 1,
      showFirst: true,
      showLast: true,
      showAlways: false,
      prevPage: 1,
      nextPage: 1,
      firstPageDisabled: false,
      prevPageDisabled: false,
      nextPageDisabled: false,
      lastPageDisabled: false,
      pages: {}
    }

    $.extend(_options, opts);

    if (options.headerContext != undefined) {
      options.headerContext.html("(" + (info.start) + " tot " + (info.end) + " van de " + info.total + " resultaten)");
    }

    curPage = _options.curPage;

    start = curPage - options.offsetLeft;
    end = parseInt(curPage) + options.offsetRight;

    start = Math.max(_options.firstPage, start);
    end = Math.min(_options.lastPage, end);

    if (curPage <= _options.firstPage)
    {
      _options.firstPageDisabled = _options.prevPageDisabled = true;
    }

    if (curPage >= _options.lastPage)
    {
      _options.lastPageDisabled = _options.nextPageDisabled = true;
    }

    _options.nextPage = Math.min(_options.lastPage, _options.nextPage);
    _options.prevPage = Math.max(_options.firstPage, _options.prevPage);

    for (var i = start; i <= end; i++)
    {
      thisPage = i == _options.curPage;
      _options.pages[i] = {
        isActive: thisPage,
        active: function(a) {
          return (a.isActive)
        },
        number: i
      };
    }

    $.globalRenderingQueue("single", {
      renderContext: options.paginationContext,
      loadingContext: options.loadingContext,
      templateUrl: base_url + "assets/include/pagination.mst",
      dataObj: _options,
      complete: function() {

          $("li.disabled a").click(function(e) {
            e.preventDefault();
          })
      },
      append: false
    });

  }

  function paginate(info, data)
  {
    options.loadingContext.removeClass("hidden");
    options.loadingContext.fadeIn(500);
    options.resultsContext.slideUp(500, function() {
      options.resultsContext.html("");
      if (info.page == undefined)
        info.page = 1;
      var start = (info.page - 1) * options.perPage;
      var type = (data==undefined) ? "GET" : "POST";
      var submitData = (data==undefined) ? {} : data;
      $.ajax({
        url: options.searchUrl + "/" + start,
        type: type,
        data: submitData,
        error: function(data) {
          console.log(data);
          $("html").html(data.responseText);
        },
        fail: function(data) {
          console.log(data);
          $("html").html(data.responseText);
        },
        success: function(d) {

          var start = (info.page-1) * options.perPage;

          paginationInfo = {
            start: start+1,
            end: start + d.users.length,
            total: d.length
          }

          totalPages = Math.ceil(d.length / options.perPage);

          paginationOpts = {
            curPage: info.page,
            firstPage: 1,
            lastPage: totalPages,
            showFirst: true,
            showLast: true,
            showAlways: false,
            prevPage: info.page-1,
            nextPage: parseInt(info.page)+1,
            firstPageDisabled: false,
            prevPageDisabled: false,
            nextPageDisabled: false,
            lastPageDisabled: false,
            pages: {}
          }

          if (d.length != 0) {
            showPagination(paginationInfo, paginationOpts);

            var userOverview = {
              renderContext: options.resultsContext,
              loadingContext: options.loadingContext,
              templateUrl: base_url + "assets/include/user_overview_single.mst",
              dataObj: d.users,
              complete: function() {
                options.loadingContext.fadeOut(500);
                options.resultsContext.slideDown(500);
                options.complete();

                $('img').on('load', function(){
                    var css;
                    var ratio=$(this).width() / $(this).height();
                    var pratio=$(this).parent().width() / $(this).parent().height();
                    if (ratio<pratio) css={width:'auto', height:'100%'};
                    else css={width:'100%', height:'auto'};
                    console.log(ratio, pratio, css);
                    $(this).css(css);
                });
              },
              removeUnmatched: false
            }

            $.globalRenderingQueue("collection", userOverview);
          } else {
            options.headerContext.html("(Geen resultaten gevonden");
            options.resultsContext.html("<h4 class='text-center'>Geen resultaten gevonden</h4>");
            options.loadingContext.fadeOut(500);
            options.resultsContext.slideDown(500);
          }

        },
        dataType: "json"
      })
    });
  }
  exports.paginate = paginate;



  function init(opt)
  {
    $.extend(options, opt);

    if (opt.searchUrl == undefined)
    {
      throw "The search url has to be given";
    }

    if (opt.renderer == undefined)
    {
      throw "The renderer must be defined";
    }
  }
  exports.init = init;

  return exports;
}
