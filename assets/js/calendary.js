(function ($) {
  "use strict";

  /* ------------------------- Constantes ------------------------- */
  var meses = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];

  var mesesLargos = [
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre",
  ];

  var citaId = 0;
  var mkId = function () {
    return "cita-" + ++citaId;
  };

  var data_response = [
    {
      date: new Date(2026, 9, 1),
      citas: [
        {
          id: mkId(),
          nombre_paciente: "María",
          apellido_paciente: "López",
          sexo: "Femenino",
          telefono: "7774577",
          nota: "Evaluación inicial y entrevista clínica, Seguimiento y revisión de avances",
          hora: "08:00",
          color: "bg-lavender",
          duracion: "90",
          estado: "Confirmada",
        },
      ],
    },

    {
      date: new Date(2026, 9, 3),
      citas: [
        {
          id: mkId(),
          nombre_paciente: "Carlos",
          apellido_paciente: "López",
          sexo: "Masculino",
          telefono: "7774577",
          nota: "Evaluación inicial y entrevista clínica, Seguimiento y revisión de avances",
          hora: "08:00",
          color: "bg-coral",
          duracion: "60",
          estado: "Confirmada",
        },
        {
          id: mkId(),
          nombre_paciente: "Ana",
          apellido_paciente: "López",
          sexo: "Femenino",
          telefono: "7774577",
          nota: "Evaluación inicial y entrevista clínica, Seguimiento y revisión de avances",
          hora: "09:00",
          color: "bg-lavender",
          duracion: "90",
          estado: "Pendiente",
        },
        {
          id: mkId(),
          nombre_paciente: "Luis",
          apellido_paciente: "López",
          sexo: "Masculino",
          telefono: "7774577",
          nota: "Evaluación inicial y entrevista clínica, Seguimiento y revisión de avances",
          hora: "15:00",
          color: "bg-mint",
          duracion: "45",
          estado: "Confirmada",
        },
      ],
    },

    {
      date: new Date(2026, 8, 1),
      citas: [
        {
          id: mkId(),
          nombre_paciente: "Sofía",
          apellido_paciente: "López",
          sexo: "Masculino",
          telefono: "7774577",
          nota: "Evaluación inicial y entrevista clínica, Seguimiento y revisión de avances",
          hora: "19:00",
          color: "bg-cream",
          duracion: "30",
          estado: "Confirmada",
        },
      ],
    },
    {
      date: new Date(2026, 8, 6),
      citas: [
        {
          id: mkId(),
          nombre_paciente: "Pedro",
          apellido_paciente: "López",
          sexo: "Masculino",
          telefono: "7774577",
          nota: "Evaluación inicial y entrevista clínica, Seguimiento y revisión de avances",
          hora: "18:00",
          color: "bg-mint",
          duracion: "45",
          estado: "Pendiente",
        },
      ],
    },
    {
      date: new Date(2026, 8, 4),
      citas: [
        {
          id: mkId(),
          nombre_paciente: "Pedro",
          apellido_paciente: "López",
          sexo: "Masculino",
          telefono: "7774577",
          nota: "Evaluación inicial y entrevista clínica, Seguimiento y revisión de avances",
          hora: "18:00",
          color: "bg-mint",
          duracion: "45",
          estado: "Confirmada",
        },
      ],
    },
  ];


  var colorClass = [
    "bg-blue-200",
    "bg-zinc-200",
    "bg-slate-200",
    "bg-red-200",
    "bg-sky-200",
    "bg-stone-200",
    "bg-teal-200",
    "bg-neutral-200",
    "bg-green-200",
    "bg-slate-300",
  ];

  var estadoClass = {
    Confirmada: {
      dot: "bg-emerald-500",
      text: "text-emerald-700",
    },
    Pendiente: {
      dot: "bg-amber-500",
      text: "text-amber-700",
    },
    Cancelada: {
      dot: "bg-red-400",
      text: "text-red-600",
    },
  };

  /* ------------------------- Estado ------------------------- */
  var currentDate = new Date();

  var state = {
    mesActivo: currentDate.getMonth(),
    mesActivoSide: currentDate.getMonth(),
    calendario: getSortOrderDays(JSON.parse(JSON.stringify(data_response))),
    colorSeleccionado: "bg-blue-200",
    busqueda: "",
  };


  /* ------------------------- Nodos ------------------------- */
  var els = {
    monthList: $("#monthList"),
    daysList: $("#daysList"),
    miniMonthTitle: $("#miniMonthTitle"),
    miniCalendar: $("#miniCalendar"),
    upcomingList: $("#upcomingList"),
    searchBar: $("#searchBar"),
    searchInput: $("#searchInput"),
    clearSearch: $("#clearSearch"),
    cancelSearch: $("#cancelSearch"),
    modalBackdrop: $("#modalBackdrop"),
    patientInput: $("#patientInput"),
    patientLasnameInput: $("#patientLasnameInput"),
    generoInput: $("#generoInput"),
    generoOtroInput: $("#gneroOtroInput"),
    timeInput: $("#timeInput"),
    dateInput: $("#dateInput"),
    coloresButtons: $("#coloresButtons"),
    formError: $("#formError"),
    modalNota: $("#modalNota"),
    closeModalNota: $("#closeModalNota"),
    notaCompleta: $("#notaCompleta"),
  };



  /* ------------------------- Utilidades ------------------------- */
  function inicialesDe(nombre) {
    var partes = String(nombre).split(" ");
    var letras = partes.map(function (n) {
      return n[0] || "";
    });
    return letras.join("").slice(0, 2).toUpperCase();
  }
  function escapeHtml(value) {
    return String(value)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }
  function formatHour(hourStr) {
    if (!hourStr) return "";
    var [hours] = hourStr.split(':').map(Number);
    var ampm = hours >= 12 ? 'PM' : 'AM';
    return hourStr + ' ' + ampm;
  }

  function hydrateIcons() {
    if (window.lucide) {
      lucide.createIcons();
    }
  }

  function totalCitasConfirmadas(monthSelected) {
    var now = new Date();
    var targetAbsoluteMonth = now.getFullYear() * 12 + monthSelected;

    return state.calendario
      .filter(function (item) {
        var d = new Date(item.date);
        return (d.getFullYear() * 12 + d.getMonth()) === targetAbsoluteMonth;
      })
      .reduce(function (total, item) {
        return total + item.citas.filter(function (cita) {
          return cita.estado === "Confirmada";
        }).length;
      }, 0);
  }
  function totalCitasPendientes(monthSelected) {
    var now = new Date();
    var targetAbsoluteMonth = now.getFullYear() * 12 + monthSelected;

    return state.calendario
      .filter(function (item) {
        var d = new Date(item.date);
        return (d.getFullYear() * 12 + d.getMonth()) === targetAbsoluteMonth;
      })
      .reduce(function (total, item) {
        return total + item.citas.filter(function (cita) {
          return cita.estado === "Pendiente";
        }).length;
      }, 0);
  }


  function diasConCita(monthSelected) {
    var now = new Date();
    var targetAbsoluteMonth = now.getFullYear() * 12 + monthSelected;

    return state.calendario
      .filter(function (item) {
        if (!item.citas || item.citas.length === 0) {
          return false;
        }
        var d = new Date(item.date);
        return (d.getFullYear() * 12 + d.getMonth()) === targetAbsoluteMonth;
      })
      .map(function (item) {
        return item;
      });
  }


  function citasFiltradas(month) {
    var q = state.busqueda.trim().toLowerCase();
    
    var filteredByMonth = state.calendario.filter(function(item) {
      return new Date(item.date).getMonth() === month;
    });

    if (!q) {
      return filteredByMonth;
    }

    return filteredByMonth.map(function (cita) {
      return {
        date: cita.date,
        citas: cita.citas.filter(function (citaFiltro) {
          return (
            citaFiltro.nombre_paciente.toLowerCase().indexOf(q) !== -1 ||
            citaFiltro.nota.toLowerCase().indexOf(q) !== -1
          );
        }),
      };
    });
  }


  function proximasCitas(monthSelected) {
    var items = [];
    var now = new Date();
    var currentMonthNow = now.getMonth();
    var currentDayNow = now.getDate();
    var targetAbsoluteMonth = now.getFullYear() * 12 + monthSelected;

    state.calendario.forEach(function (element) {
      var date = new Date(element.date);
      if ((date.getFullYear() * 12 + date.getMonth()) === targetAbsoluteMonth) {
        element.citas.forEach(function (cita) {
          if (currentMonthNow == date.getMonth() && now.getFullYear() == date.getFullYear()) {
            if (date.getDate() > currentDayNow) {
              items.push({ cita: cita, dia: date.getDate() });
            }
          }
          else {
            items.push({ cita: cita, dia: date.getDate() });
          }
        });
      }
    });
    
    return items.slice(0, 5);
  }



  /* ------------------------- Render: meses ------------------------- */
  function renderMonths() {
    var now = new Date();
    var currentMonth = now.getMonth();
    var currentYear = now.getFullYear();
    
    var monthsToRender = [];
    for (var i = -3; i <= 3; i++) {
      var date = new Date(currentYear, currentMonth + i, 1);
      monthsToRender.push({
        name: meses[date.getMonth()],
        absoluteIndex: currentMonth + i
      });
    }

    els.monthList.html(
      monthsToRender.map(function (m) {
        return (
          '<button type="button"' +
          ' class="h-8 min-w-[85px] shrink-0 rounded-full text-sm font-semibold transition ' +
          (state.mesActivoSide === m.absoluteIndex
            ? "bg-black text-white shadow-sm"
            : "bg-slate-50 text-slate-700 hover:bg-slate-300") +
          '" data-month="' +
          m.absoluteIndex +
          '">' +
          m.name +
          "</button>"
        );
      }).join("")
    );
  }

  function appointmentCard(cita, day) {
    var status = estadoClass[cita.estado];

    return (
      '<article class="' +
      cita.color +
      ' overflow-visible min-w-[180px] max-w-[180px] rounded-xl p-2.5 shadow-sm sm:min-w-[188px]">' +
      '<div class="flex items-start gap-2 px-0.5 pb-2">' +
      '<span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-xs font-semibold text-slate-800 shadow-sm">' +
      inicialesDe(cita.nombre_paciente) +
      "</span>" +
      '<div class="min-w-0 flex-1 pt-0.5">' +
      '<p class="truncate text-sm font-semibold text-slate-900">' +
      escapeHtml(cita.nombre_paciente) + " " + escapeHtml(cita.apellido_paciente) +
      "</p>" +
      '<p class="text-xs text-slate-600">' +
      escapeHtml(formatHour(cita.hora)) +
      " · " +
      escapeHtml(cita.duracion) +
      "</p>" +

      "</div>" +
      "</div>" +
      '<div class="flex items-center gap-2 rounded-lg bg-white/90 px-2 py-2 shadow-sm cursor-pointer" onclick="abrirModalNota(`' + escapeHtml(cita.nota) + '`)">' +
      '<span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-slate-50 text-slate-800">' +
      '<i data-lucide="clipboard-list" class="h-3.5 w-3.5"></i>' +
      "</span>" +
      '<p class="truncate text-xs font-semibold text-slate-900 w-max-10">' +
      escapeHtml(cita.nota) +
      "</p>" +
      "</div>" +
      '<div class="relative flex items-center justify-between gap-1 pt-2 text-xs font-medium">' +
      '<button type="button" class="flex items-center gap-1 rounded-full bg-white/90 px-2 py-1 text-slate-700 transition hover:bg-white">' +
      '<span class="h-1.5 w-1.5 rounded-full ' +
      status.dot +
      '"></span>' +
      '<span class="' +
      status.text +
      '">' +
      cita.estado +
      "</span>" +
      "</button>" +

      '<button type="button" data-action="menu" data-id="' +
      cita.id +
      '"' +
      ' class="rounded p-1 text-slate-800 transition hover:bg-black/10" aria-label="Más opciones">' +
      '<i data-lucide="ellipsis" class="h-[15px] w-[15px]"></i>' +
      "</button>" +
      '<div id="menu-' +
      cita.id +
      '" class="absolute justify-items-center bottom-9 right-0 z-20 hidden w-36 h-50 rounded-lg border border-slate-300 bg-slate-100 py-1 shadow-lg">' +
      '<button type="button" data-action="delete" data-day="' +
      day +
      '" data-id="' +
      cita.id +
      '"' +
      ' class="flex rounded-full items-center m-2 gap-2 px-3 py-2 text-left text-xs font-medium text-red-600 transition hover:bg-red-200">' +
      '<i data-lucide="trash-2" class="h-[13px] w-[13px]"></i>Eliminar Cita' +
      "</button>" +
      `<div class="flex flex-col gap-2 border-t border-slate-300 px-2 py-3">
      
          <button
              type="button"
              data-action="update-status"
              data-id="${cita.id}"
              data-day="${day}"
              data-status="Confirmada"
              class="flex w-full rounded-full items-center gap-2 px-3 py-2 text-left text-xs font-medium text-green-600 transition hover:bg-green-200">
              <i data-lucide="check-circle" class="h-[13px] w-[13px]"></i>
              Confirmar
          </button>
      
          <button
              type="button"
              data-action="update-status"
              data-id="${cita.id}"
              data-day="${day}"
              data-status="Pendiente"
              class="flex w-full rounded-full items-center gap-2 px-3 py-2 text-left text-xs font-medium text-orange-800 transition hover:bg-orange-200">
              <i data-lucide="clock-3" class="h-[13px] w-[13px]"></i>
              Pendiente
          </button>
      
          <button
              type="button"
              data-action="update-status"
              data-id="${cita.id}"
              data-day="${day}"
              data-status="Cancelada"
              class="flex w-full rounded-full items-center gap-2 px-3 py-2 text-left text-xs font-medium text-red-600 transition hover:bg-red-200">
              <i data-lucide="x-circle" class="h-[13px] w-[13px]"></i>
              Cancelar
          </button>
      
      </div>`+
      "</div>" +
      "</div>" +
      "</article>"

    );
  }
  function renderDays() {
    var days = citasFiltradas(state.mesActivoSide);
    
    if(days.length == 0){
      els.daysList.html(
        [1].map(function (item) {
          var inner =
              '<div class="text-sm text-slate-600 content-center text-center">Sin resultados.</div>';
          return (
            '<div class="grid min-h-[82px] border-b border-slate-300 grid-cols-[30px_minmax(0,1fr)] gap-3 px-5 py-4 sm:grid-cols-[38px_minmax(0,1fr)] sm:px-8">' +
            '<div class="pt-1 text-xs font-semibold text-slate-800">1</div>' +
            inner +
            "</div>"
          );
        }).join(""),
      );
      return;
    }
    els.daysList.html(
      days
        .map(function (item) {
          var inner;
          const fecha = new Date(item.date);
          const dia = fecha.getDate();
        
          if (item.citas.length) {
            inner =
              '<div class="flex gap-2 pb-1">' +
              item.citas
                .map(function (cita) {
                  return appointmentCard(cita, dia);
                })
                .join("") +
              "</div>";
          } else {
            inner =
              '<div class="pt-1 text-xs text-slate-400">' +
              (state.busqueda
                ? "Sin resultados."
                : "Sin citas.") +
              "</div>";
          }

          return (
            '<div class="grid min-h-[82px] border-b border-slate-300 grid-cols-[30px_minmax(0,1fr)] gap-3 px-5 py-4 sm:grid-cols-[38px_minmax(0,1fr)] sm:px-8">' +
            '<div class="pt-1 text-xs font-semibold text-slate-800">' +
            dia +
            "</div>" +
            inner +
            "</div>"
          );
        })
        .join(""),
    );
  }
  function sonTodasEstadoDelDia(estado,citas){
    let result = true;
    citas.forEach(element => {
      if(element.estado != estado){
        result = false;
      }
    });
    return result;
  }
  function renderMiniCalendar() {
    var year = currentDate.getFullYear();
    var month = currentDate.getMonth();

    var total = totalCitasConfirmadas(month);
    var totalPendientes = totalCitasPendientes(month);


    var firstDayOfMonth = new Date(year, month, 1).getDay();
    var daysInMonth = new Date(year, month + 1, 0).getDate();

    var firstDayAdjusted = firstDayOfMonth === 0 ? 6 : firstDayOfMonth - 1;

    var calendario = [];
    var prevMonthLastDay = new Date(year, month, 0).getDate();

    for (var i = firstDayAdjusted - 1; i >= 0; i--) {
      calendario.push(prevMonthLastDay - i);
    }
    for (var i = 1; i <= daysInMonth; i++) {
      calendario.push(i);
    }
    var remaining = 42 - calendario.length;
    for (var i = 1; i <= remaining; i++) {
      calendario.push(i);
    }

    var weekDays = ["Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"];
    var appointmentDays = diasConCita(month);
   
    var html = "";

    html += '<div class="mt-5">';
    html +=
      '<div class="grid grid-cols-7 gap-y-2 text-center text-xs font-bold text-slate-800">';
    html += weekDays
      .map(function (d) {
        return "<span>" + d + "</span>";
      })
      .join("");

    calendario.forEach(function (day, index) {
      
      var outside = index < firstDayAdjusted || index >= firstDayAdjusted + daysInMonth;
      
      var appointmentDay = appointmentDays.find(function(item) {
        const fecha = new Date(item.date);
        return fecha.getDate() === day;
      });

      var hasAppointment = appointmentDay !== undefined && !outside;

      var colorMark = "bg-red-500";
    
      if(hasAppointment && sonTodasEstadoDelDia("Pendiente",appointmentDay.citas)){
      
        colorMark = "bg-orange-500";
      }
      else if(hasAppointment && sonTodasEstadoDelDia("Cancelada",appointmentDay.citas)){
        colorMark = "bg-white";
      }

      const currentDateNow = new Date();
      const currentMonthNow = currentDateNow.getMonth();
      const currentDayNow = currentDateNow.getDate();
      if (currentMonthNow == month) {

        if (day < currentDayNow) {
          colorMark = "bg-slate-500";
        }
      }
      console.log(appointmentDay);
      html +=
        '<button type="button"' +
        (outside ? " disabled" : "") +
        ' data-mini-day="' +
        day +
        '"' +
        ' class="relative mx-auto flex h-7 w-7 items-center justify-center rounded-full text-xs font-medium transition ' +
        (outside
          ? "cursor-default text-slate-300"
          : "cursor-pointer text-slate-700 hover:bg-slate-300") +
        '">' +
        day +
        (hasAppointment
          ? '<i class="absolute bottom-0 h-1.5 w-1.5 rounded-full ' + colorMark + ' animate-bounce"></i>'
          : "") +
        "</button>";
    });

    html += "</div>";
    html +=
      '<div class="mt-4 flex items-center gap-2 text-xs text-slate-600">';
    html +=
      '<span class="h-1.5 w-1.5 rounded-full bg-red-500 animate-bounce"></span>' + total + ' Confirmadas ';
    html +=
      '<span class="h-1.5 w-1.5 rounded-full bg-orange-500 animate-bounce"></span>' + totalPendientes + ' Pendientes';
    html += "</div>";
    html += "</div>";

    els.miniCalendar.html(html);
  }
  function upcomingCard(cita, dia) {
    var status = estadoClass[cita.estado];
    return (
      '<div class="' +
      cita.color +
      ' flex items-start gap-3 rounded-xl p-3.5">' +
      '<span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-xs font-semibold">' +
      inicialesDe(cita.nombre_paciente) +
      "</span>" +
      '<div class="min-w-0 flex-1">' +
      '<p class="text-xs font-semibold">' +
      escapeHtml(cita.nombre_paciente) + " " + escapeHtml(cita.apellido_paciente) +
      "</p>" +
      '<p class="mt-0.5 max-w-180 truncate text-xs text-slate-600 cursor-pointer" onclick="abrirModalNota(`' + escapeHtml(cita.nota) + '`)">' +
      escapeHtml(cita.nota) +
      "</p>" +
      '<p class="mt-0.5 text-xs text-slate-500">' +
      dia +
      " " +
      meses[state.mesActivo] +
      " · " +
      escapeHtml(formatHour(cita.hora)) +
      "</p>" +
      "</div>" +
      '<div class="flex flex-col items-end gap-2">' +
      '<span class="flex items-center gap-1 rounded-full bg-white px-2 py-0.5 text-xs font-semibold ' +
      status.text +
      '">' +
      '<span class="h-1.5 w-1.5 rounded-full ' +
      status.dot +
      '"></span>' +
      cita.estado +
      "</span>" +
      '<button type="button" data-action="menu" data-id="' +
      cita.id +
      '"' +
      ' class="rounded p-1 text-slate-800 transition hover:bg-black/10" aria-label="Más opciones">' +
      '<i data-lucide="ellipsis" class="h-[15px] w-[15px]"></i>' +
      "</button>" +
      '<div id="menu-mini-' +
      cita.id +
      '" class="absolute justify-items-center z-20 hidden w-36 h-50 rounded-lg border border-slate-300 bg-slate-100 py-1 shadow-lg">' +
      '<button type="button" data-action="delete" data-day="' +
      dia +
      '" data-id="' +
      cita.id +
      '"' +
      ' class="flex rounded-full items-center m-2 gap-2 px-3 py-2 text-left text-xs font-medium text-red-600 transition hover:bg-red-200">' +
      '<i data-lucide="trash-2" class="h-[13px] w-[13px]"></i>Eliminar Cita' +
      "</button>" +
      `<div class="flex flex-col gap-2 border-t border-slate-300 px-2 py-3">
      
          <button
              type="button"
              data-action="update-status"
              data-id="${cita.id}"
              data-day="${dia}"
              data-status="Confirmada"
              class="flex w-full rounded-full items-center gap-2 px-3 py-2 text-left text-xs font-medium text-green-600 transition hover:bg-green-200">
              <i data-lucide="check-circle" class="h-[13px] w-[13px]"></i>
              Confirmar
          </button>
      
          <button
              type="button"
              data-action="update-status"
              data-id="${cita.id}"
              data-day="${dia}"
              data-status="Pendiente"
              class="flex w-full rounded-full items-center gap-2 px-3 py-2 text-left text-xs font-medium text-orange-800 transition hover:bg-orange-200">
              <i data-lucide="clock-3" class="h-[13px] w-[13px]"></i>
              Pendiente
          </button>
      
          <button
              type="button"
              data-action="update-status"
              data-id="${cita.id}"
              data-day="${dia}"
              data-status="Cancelada"
              class="flex w-full rounded-full items-center gap-2 px-3 py-2 text-left text-xs font-medium text-red-600 transition hover:bg-red-200">
              <i data-lucide="x-circle" class="h-[13px] w-[13px]"></i>
              Cancelar
          </button>
      
      </div>`+
      "</div>" +

      "</div>" +
      "</div>"
    );
  }

  function renderUpcoming() {
    var items = proximasCitas(state.mesActivo);

    els.upcomingList.html(
      items.length
        ? '<div class="space-y-3">' +
        items
          .map(function (element) {
            return upcomingCard(element.cita, element.dia);
          })
          .join("") +
        "</div>"
        : '<p class="text-xs text-slate-400">No hay citas programadas.</p>',
    );
  }
  function renderFormDays() {
    els.coloresButtons.html(
      colorClass
        .map(function (color) {

          return (
            '<button type="button" data-form-day="' +
            color +
            '"' +
            ' class="h-7 w-7 rounded-full text-xs font-medium transition  ' +
            (state.colorSeleccionado == color
              ? color + " border border-black/80"
              : color) +
            '">' +
            "</button>"
          );
        })
        .join(""),
    );
  }
  function getSortOrderDays(citas) {
    return citas
      .map(function (item) {
        return {
          ...item,
          citas: item.citas.sort(function (a, b) {
            return a.hora.localeCompare(b.hora);
          }),
        };
      })
      .sort(function (a, b) {
        var dateA = new Date(a.date);
        var dateB = new Date(b.date);
        return dateA - dateB;
      });
  }
  function render() {
    state.calendario = getSortOrderDays(state.calendario);

    renderMonths();

    els.miniMonthTitle.text(mesesLargos[currentDate.getMonth()] + " " + currentDate.getFullYear());

    renderDays();
    renderMiniCalendar();
    renderUpcoming();
    renderFormDays();

    hydrateIcons();
  }
  function navegarMes(delta) {
    state.mesActivo = Math.max(
      0,
      Math.min(meses.length - 1, state.mesActivo + delta),
    );

    var newDate = new Date(currentDate);
    newDate.setMonth(newDate.getMonth() + delta);
    currentDate = newDate;

    render();
  }

  /* ------------------------- Modal ------------------------- */
  function abrirModal() {
    els.formError.addClass("hidden");
    els.modalBackdrop.removeClass("hidden").addClass("flex");
    setTimeout(function () {
      els.patientInput.trigger("focus");
    }, 0);
  }

  function cerrarModal() {
    els.modalBackdrop.addClass("hidden").removeClass("flex");
    els.formError.addClass("hidden");
  }

  window.abrirModalNota = function(texto) {
    els.notaCompleta.text(texto);
    els.modalNota.removeClass("hidden").addClass("flex");
}

  function cerrarModalNota() {
    els.modalNota.addClass("hidden").removeClass("flex");
  }

  function mostrarError(message) {

    els.formError.text(message).removeClass("hidden");
  }

  /* ------------------------- Acciones de cita ------------------------- */
  function agregarCita() {
    var nombre_paciente = els.patientInput.val().trim();
    var apellido_paciente = els.patientLasnameInput.val().trim();
    var genero = els.generoInput.val();
    var hora = els.timeInput.val().trim();
    var fecha = els.dateInput.val();
    var estado = $("#estadoInput").val();
    var duracion = $("#timeMaxInput").val().trim();

    if (genero === "Otro") {
      genero = els.generoOtroInput.val().trim();
    }

    if (!nombre_paciente || !apellido_paciente || !hora || !fecha || !genero || !estado || !duracion) {
      mostrarError("Por favor completa todos los campos.");
      return;
    }

    var color = state.colorSeleccionado;

    var nuevaCita = {
      id: mkId(),
      nombre_paciente: nombre_paciente,
      apellido_paciente: apellido_paciente,
      sexo: genero,
      telefono: $("#telefonoInput").val().trim(),
      nota: "Cita agendada desde calendario",
      hora: hora,
      color: color,
      duracion: duracion,
      estado: estado,
    };

    var dateObj = new Date(fecha + "T00:00:00");
    var day = dateObj.getDate();

    var existingDay = state.calendario.find(function (item) {
      return new Date(item.date).toDateString() === dateObj.toDateString();
    });

    if (existingDay) {
      existingDay.citas.push(nuevaCita);
    } else {
      state.calendario.push({
        day: day,
        date: dateObj,
        citas: [nuevaCita]
      });
    }

    els.patientInput.val("");
    els.patientLasnameInput.val("");
    els.generoInput.val("");
    els.generoOtroInput.val("");
    els.timeInput.val("");
    els.dateInput.val("");
    $("#timeMaxInput").val("");

    cerrarModal();
    render();
  }


  function eliminarCita(id) {
    state.calendario = state.calendario.map(function (item) {
      return {
        ...item,
        citas: item.citas.filter(function (cita) {
          return cita.id !== id;
        })
      };
    });
    render();
  }

  function closeMenus() {
    $('[id^="menu-"]').addClass("hidden");
    $('[id^="menu-mini-"]').addClass("hidden");
  }

  /* ------------------------- Eventos ------------------------- */
  function bindEvents() {
    // Modal
    $("#openModal").on("click", abrirModal);
    $("#closeModal").on("click", cerrarModal);
    $("#saveAppointment").on("click", agregarCita);
    
    els.closeModalNota.on("click", cerrarModalNota);
    els.modalNota.on("click", function (e) {
      if (e.target === this) {
        cerrarModalNota();
      }
    });

    els.modalBackdrop.on("click", function (e) {
      if (e.target === this) {
        cerrarModal();
      }
    });

    // Mini calendario navigation
    $("#prevMonth").on("click", function () {
      navegarMes(-1);
    });
    $("#nextMonth").on("click", function () {
      navegarMes(1);
    });


    // Botones de mes (delegación, contenido dinámico)
    els.monthList.on("click", "[data-month]", function () {
      state.mesActivoSide = Number($(this).data("month"));
      render();
    });


    els.searchInput.on("input", function () {
      state.busqueda = $(this).val();
      renderDays();
      hydrateIcons();
    });

    els.clearSearch.on("click", function () {
      state.busqueda = "";
      els.searchInput.val("");
      els.clearSearch.addClass("hidden");
      renderDays();
      hydrateIcons();
    });

    els.cancelSearch.on("click", function () {
      state.busqueda = "";
      els.searchInput.val("");
      render();
    });

    els.daysList.on("click", '[data-action="menu"]', function (e) {
      e.stopPropagation();
      closeMenus();
      $("#menu-" + $(this).data("id")).toggleClass("hidden");
    });
    els.upcomingList.on("click", '[data-action="menu"]', function (e) {
      e.stopPropagation();
      closeMenus();
      $("#menu-mini-" + $(this).data("id")).toggleClass("hidden");
    });

    els.daysList.on("click", '[data-action="delete"]', function () {
      eliminarCita($(this).data("id"));
    });
    els.upcomingList.on("click", '[data-action="delete"]', function () {
      eliminarCita($(this).data("id"));
    });

    // Mini calendario (delegación)
    els.miniCalendar.on("click", "[data-mini-day]", function () {
      var day = Number($(this).data("miniDay"));
      var year = currentDate.getFullYear();
      var month = currentDate.getMonth();

      var selectedDate = new Date(year, month, day);
      var dateString = selectedDate.toISOString().split('T')[0];

      $("#dateInput").val(dateString);
      abrirModal();
    });

    // Mostrar/Ocultar campo "Otro" género
    els.generoInput.on("change", function () {
      if ($(this).val() === "Otro") {
        els.generoOtroInput.removeClass("hidden");
      } else {
        els.generoOtroInput.addClass("hidden");
      }
    });

    // Días del formulario (delegación)
    els.coloresButtons.on("click", "[data-form-day]", function () {
      state.colorSeleccionado = $(this).data("formDay");
      renderFormDays();
    });

    // Cerrar menús flotantes con clic fuera / tecla Escape
    $(document).on("click", closeMenus);

    $(document).on("keydown", function (e) {
      if (e.key === "Escape") {
        closeMenus();

        if (!els.modalBackdrop.hasClass("hidden")) {
          cerrarModal();
        }
      }
    });
  }

  bindEvents();
  render();
})(jQuery);
