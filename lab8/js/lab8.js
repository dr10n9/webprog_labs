$(function () {
    var calendar = new DayPilot.Scheduler("calendar");
    calendar.startDate = DayPilot.Date.today().firstDayOfMonth(); 
    calendar.days = DayPilot.Date.today().daysInMonth();
    calendar.scale = "Day"; 
    calendar.timeHeaders = [ 
        { groupBy: "Month", format: "MMMM yyyy" },
        { groupBy: "Day", format: "d" }
    ];
    
    calendar.init();

    
    $.getJSON("php/getRooms.php", function (data) {
        calendar.resources = data;
        calendar.update();
    });

    $.getJSON("php/getReservations.php", function (data) {
        calendar.events.list = data;
        calendar.update();
    });

    calendar.onTimeRangeSelected = function (args) {
        var modal = new DayPilot.Modal();
        modal.closed = function () {
            calendar.clearSelection();
            loadEvents();  
        };
        modal.showUrl("php/forms/create.php?start=" + args.start + "&end=" + args.end + "&resource=" + args.resource);
    };

    calendar.onEventMoved = function (args) {
        $.post("php/updateReservation.php", {
            id: args.e.id(),
            start: args.newStart.toString(),
            end: args.newEnd.toString(),
            room_id: args.newResource
        });
    };

    calendar.onEventClick = function (args) {
        var modal = new DayPilot.Modal();
        modal.closed = function () {
            loadEvents(); 
        };

        const params = args.e.data;
        console.log(params);
        modal.showUrl(`php/forms/update.php?id=${params.id}&start=${params.start}&end=${params.end}&resource=${params.resource}`);
    };

    function loadEvents() {
        $.getJSON("php/getRooms.php", function (data) {
            calendar.resources = data;
            calendar.update();
        });

        $.getJSON("php/getReservations.php", function (data) {
            calendar.events.list = data;
            calendar.update();
        });
    }
});