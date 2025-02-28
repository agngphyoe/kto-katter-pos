var searchInput = $("#searchInput");
var searchProductLocation = $("#searchProductLocation");
var dateRangeInput = $('input[name="daterange"]');
var startDate = null;
var endDate = null;
var currentPage = 1;

function executeSearch(route, reattachAndReload = false, limit = false) {
    var pages = getUrlParameter("page");
    currentPage = pages || currentPage;

    var name = getRouteNameFromUrl();
    var currentRoute = `${name}_search`;

    var storedData = localStorage.getItem(currentRoute);

    if (storedData) {
        var searchData = JSON.parse(storedData);

        searchInput.val(searchData.search);
        searchProductLocation.val(searchData.location);
        
        if (searchData.startDate) {
            dateRangeInput
                .data("daterangepicker")
                .setStartDate(moment(searchData.startDate, "YYYY-MM-DD"));
        }

        if (searchData.endDate) {
            dateRangeInput
                .data("daterangepicker")
                .setEndDate(moment(searchData.endDate, "YYYY-MM-DD"));
        }

        startDate = searchData.startDate;
        endDate = searchData.endDate;
    }

    dateRangeInput.on("apply.daterangepicker", function (ev, picker) {
        startDate = picker.startDate.format("YYYY-MM-DD");
        endDate = picker.endDate.format("YYYY-MM-DD");

        var searchData = {
            search: searchInput.val(),
            location: searchProductLocation.val(),
            startDate: startDate,
            endDate: endDate,
        };

        localStorage.setItem(currentRoute, JSON.stringify(searchData));

        callSearchAjax(
            route,
            startDate,
            endDate,
            limit,
            currentPage,
            reattachAndReload
        );
        setDataForExportForm(startDate, endDate);
    });

    searchInput.on("input", function () {
        var searchData = {
            search: searchInput.val(),
            location: searchProductLocation.val(),
            startDate: startDate,
            endDate: endDate,
        };
        searchProductLocation.val(searchData.location);
        localStorage.setItem(currentRoute, JSON.stringify(searchData));

        callSearchAjax(
            route,
            startDate,
            endDate,
            limit,
            currentPage,
            reattachAndReload
        );
        setDataForExportForm(startDate, endDate);
    });

    searchProductLocation.on("change" , function () {
        var searchData = {
            search: searchInput.val(),
            location: searchProductLocation.val(),
            startDate: startDate,
            endDate: endDate,
        };

        localStorage.setItem(currentRoute, JSON.stringify(searchData));

        callSearchAjax(
            route,
            startDate,
            endDate,
            limit,
            currentPage,
            reattachAndReload
        );
        setDataForExportForm(startDate, endDate);
    })

    searchInput.on("change", function () {
        var searchData = {
            search: searchInput.val(),
            location: searchProductLocation.val(),
            startDate: startDate,
            endDate: endDate,
        };

        localStorage.setItem(currentRoute, JSON.stringify(searchData));

        callSearchAjax(
            route,
            startDate,
            endDate,
            limit,
            currentPage,
            reattachAndReload
        );
        setDataForExportForm(startDate, endDate);
    });

    if (storedData) {
        var searchData = JSON.parse(storedData);

        if (searchData.search || (searchData.startDate && searchData.endDate)) {
            // Execute search on page load
            callSearchAjax(
                route,
                startDate,
                endDate,
                limit,
                currentPage,
                reattachAndReload
            );
        }
        setDataForExportForm(startDate, endDate);
    } else {
        getPaginateAndExecute(route, startDate, endDate, limit);
    }
}

function callSearchAjax(
    route,
    startDate,
    endDate,
    limit,
    page,
    reattachAndReload = false
) {
    var searchInput = $("#searchInput");
    var searchProductLocation = $("#searchProductLocation");
    $.ajax({
        url: route,
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            search: searchInput.val(),
            location: searchProductLocation.val(),
            start_date: startDate,
            end_date: endDate,
            limit: limit,
            page: page,
        },
        success: function (response) {
            
            $("#searchResults").html(response.html);
            
            if (reattachAndReload) {
                reattachCheckboxListeners();
                handlePageLoading(reattachAndReload);
            }
            $(".pagination").html(response.pagination.links);

            getPaginateAndExecute(route, startDate, endDate, limit);

            var pageCount = response.pagination.last_page;

            var total = response.pagination.records_per_page;            
            
            $(".pagination").toggle(pageCount > 1);

            if(response.search_count == response.total_count){
                $(".showTotal").text(0);
            }else{
                $(".showTotal").text(total);
            }
            
        },
        error: function (xhr, status, error) {
            console.log(error);
        },
    });
}

function getUrlParameter(name) {
    var results = new RegExp("[?&]" + name + "=([^&#]*)").exec(
        window.location.href
    );
    if (results == null) {
        return null;
    } else {
        return decodeURI(results[1]) || 0;
    }
}

function getRouteNameFromUrl() {
    var url = window.location.href;

    var pathName = new URL(url).pathname;

    var parts = pathName.split("/").filter((part) => part !== "");

    if (parts.length >= 2) {
        return parts.slice(-2).join("/");
    } else {
        return parts[0] || null;
    }
}

function getPaginateAndExecute(route, startDate, endDate, limit) {
    $(".pagination a").on("click", function (event) {
        event.preventDefault();

        var newPage = $(this).data("page");

        newPage = parseInt(newPage);

        callSearchAjax(route, startDate, endDate, limit, newPage);
    });
}

function setDataForExportForm(startDate, endDate) {
    $("#name_for_export").val($("#searchInput").val());
    $("#start_date_for_export").val(startDate);
    $("#end_date_for_export").val(endDate);
}
