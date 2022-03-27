class Model {}

class View {}

class Controller {}

document.addEventListener("DOMContentLoaded", () => {
  const model = new Model();
  const view = new View();
  new Controller(model, view);
  const Calendar = tui.Calendar;
  const calendar = new Calendar("#calendar", {
    defaultView: "month",
    taskView: true,
    template: {
      monthDayname: function (dayname) {
        return (
          '<span class="calendar-week-dayname-name">' +
          dayname.label +
          "</span>"
        );
      },
    },
  });
});
