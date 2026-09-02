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

  var sexoLista = ["Seleccionar Genero", "Masculino", "Femenino", "Otro"];

  var citaId = 0;
  var mkId = function () {
    return "cita-" + ++citaId;
  };

  var diasIniciales = [
    {
      day: 1,
      date: new Date(2026, 8, 1),
      time: "14:30",
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
      day: 3,
      date: new Date(2026, 8, 3),
      time: "14:30",
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
      day: 5,
      date: new Date(2026, 8, 5),
      time: "14:30",
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
      day: 6,
      date: new Date(2026, 8, 6),
      time: "14:30",
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
  ];


  var colorClass = [
    "bg-blue-200",
    "bg-purple-200",
    "bg-pink-200",
    "bg-rose-200",
    "bg-sky-200",
    "bg-cyan-200",
    "bg-teal-200",
    "bg-emerald-200",
    "bg-green-200",
    "bg-yellow-200",
  ];
  var siguienteEstado = {
    Confirmada: "Pendiente",
    Pendiente: "Cancelada",
    Cancelada: "Confirmada",
  };

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
  var state = {
    currentDate: new Date(2026, 0, 1),
    mesActivo: 0,
    nombre_paciente: "",
    nota: "",
    hora: "",
    citas: JSON.parse(JSON.stringify(diasIniciales)),
    colorSeleccionado: "bg-blue-200",
    busqueda: "",
    busquedaActiva: false,
  };
  var currentDate = new Date();
  var mesActivo = currentDate.getMonth();

  var currentDateSide = new Date();
  var mesActivoSide = currentDate.getMonth();
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
    return hourStr+ ' ' + ampm;
  }

  function hydrateIcons() {
    if (window.lucide) {
      lucide.createIcons();
    }
  }

  function totalCitasConfirmadas(month) {

    return state.citas
      .filter(function (item) {
        return new Date(item.date).getMonth() === month;
      })
      .reduce(function (total, item) {
        return total + item.citas.filter(function (cita) {
          return cita.estado === "Confirmada";
        }).length;
      }, 0);
  }
  function totalCitasPendientes(month) {

    return state.citas
      .filter(function (item) {
        return new Date(item.date).getMonth() === month;
      })
      .reduce(function (total, item) {
        return total + item.citas.filter(function (cita) {
          return cita.estado === "Pendiente";
        }).length;
      }, 0);
  }

  function diasConCita(month) {

    return state.citas
      .filter(function (item) {
        if (!item.citas || item.citas.length === 0) {
          return false;
        }

        const fecha = new Date(item.date);
        return fecha.getMonth() === month;
      })
      .map(function (item) {
        const fecha = new Date(item.date);

        return fecha.getDate();
      });
  }

  function citasFiltradas() {
    var q = state.busqueda.trim().toLowerCase();

    if (!q) {
      return state.citas;
    }

    return state.citas.map(function (cita) {
      return {
        day: cita.day,
        citas: cita.citas.filter(function (citaFiltro) {
          return (
            citaFiltro.nombre_paciente.toLowerCase().indexOf(q) !== -1 ||
            citaFiltro.nota.toLowerCase().indexOf(q) !== -1
          );
        }),
      };
    });
  }

  function proximasCitas() {
    var items = [];

    state.citas.forEach(function (day) {
      day.citas.forEach(function (cita) {
        items.push({ cita: cita, day: day.day });
      });
    });

    return items.slice(0, 5);
  }

  /* ------------------------- Render: meses ------------------------- */
  function renderMonths() {
    els.monthList.html(
      meses
        .map(function (mes, i) {
          return (
            '<button type="button"' +
            ' class="h-8 min-w-[85px] shrink-0 rounded-full text-sm font-semibold transition ' +
            (mesActivoSide === i
              ? "bg-black text-white shadow-sm"
              : "bg-slate-50 text-slate-700 hover:bg-slate-300") +
            '" data-month="' +
            i +
            '">' +
            mes +
            "</button>"
          );
        })
        .join(""),
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
      '<div class="flex items-center gap-2 rounded-lg bg-white/90 px-2 py-2 shadow-sm">' +
      '<span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-slate-50 text-slate-800">' +
      '<i data-lucide="clipboard-list" class="h-3.5 w-3.5"></i>' +
      "</span>" +
      '<p class="truncate text-xs font-semibold text-slate-900 w-max-10">' +
      escapeHtml(cita.nota) +
      "</p>" +
      "</div>" +
      '<div class="relative flex items-center justify-between gap-1 pt-2 text-xs font-medium">' +
      '<button type="button" data-action="toggle-status" data-day="' +
      day +
      '" data-id="' +
      cita.id +
      '"' +
      ' class="flex items-center gap-1 rounded-full bg-white/90 px-2 py-1 text-slate-700 transition hover:bg-white">' +
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
              class="flex w-full rounded-full items-center gap-2 px-3 py-2 text-left text-xs font-medium text-green-600 transition hover:bg-green-200">
              <i data-lucide="check-circle" class="h-[13px] w-[13px]"></i>
              Confirmar
          </button>

          <button
              type="button"
              class="flex w-full rounded-full items-center gap-2 px-3 py-2 text-left text-xs font-medium text-orange-800 transition hover:bg-orange-200">
              <i data-lucide="clock-3" class="h-[13px] w-[13px]"></i>
              Pendiente
          </button>

          <button
              type="button"
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
    var days = citasFiltradas();

    els.daysList.html(
      days
        .map(function (day) {
          var inner;

          if (day.citas.length) {
            inner =
              '<div class="flex gap-2 pb-1">' +
              day.citas
                .map(function (cita) {
                  return appointmentCard(cita, day.day);
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
            day.day +
            "</div>" +
            inner +
            "</div>"
          );
        })
        .join(""),
    );
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
      var hasAppointment =
        appointmentDays.indexOf(day) !== -1 && !outside;

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
          ? '<i class="absolute bottom-0 h-1.5 w-1.5 rounded-full bg-red-500 animate-bounce"></i>'
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
  function upcomingCard(cita, day) {
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
      '<p class="mt-0.5 max-w-180 truncate  text-xs text-slate-600">' +
      escapeHtml(cita.nota) +
      "</p>" +
      '<p class="mt-0.5 text-xs text-slate-500">' +
      day +
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
      "</div>" +
      "</div>"
    );
  }

  function renderUpcoming() {
    var items = proximasCitas();

    els.upcomingList.html(
      items.length
        ? '<div class="space-y-3">' +
        items
          .map(function (x) {
            return upcomingCard(x.cita, x.day);
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
  function render() {
    renderMonths();

    els.miniMonthTitle.text(mesesLargos[currentDate.getMonth()] + " " + currentDate.getFullYear());

    renderDays();
    renderMiniCalendar();
    renderUpcoming();
    renderFormDays();

    hydrateIcons();
  }
  function navegarMes(delta) {
    mesActivo = Math.max(
      0,
      Math.min(meses.length - 1, mesActivo + delta),
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

    var existingDay = state.citas.find(function (item) {
      return new Date(item.date).toDateString() === dateObj.toDateString();
    });

    if (existingDay) {
      existingDay.citas.push(nuevaCita);
    } else {
      state.citas.push({
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


  function eliminarCita(day, id) {
    state.citas = state.citas.map(function (item) {
      return item.day === day
        ? {
          day: item.day,
          citas: item.citas.filter(function (cita) {
            return cita.id !== id;
          }),
        }
        : item;
    });

    render();
  }

  function toggleEstado(day, id) {
    state.citas = state.citas.map(function (item) {
      if (item.day !== day) {
        return item;
      }

      return {
        day: item.day,
        citas: item.citas.map(function (cita) {
          if (cita.id !== id) {
            return cita;
          }

          return $.extend({}, cita, {
            estado: siguienteEstado[cita.estado],
          });
        }),
      };
    });

    render();
  }

  function closeMenus() {
    $('[id^="menu-"]').addClass("hidden");
  }

  /* ------------------------- Eventos ------------------------- */
  function bindEvents() {
    // Modal
    $("#openModal").on("click", abrirModal);
    $("#closeModal").on("click", cerrarModal);
    $("#saveAppointment").on("click", agregarCita);

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

    // Navegación de meses side
    $("#prevMonthSide").on("click", function () {
      //navegarMes(-1);
    });
    $("#nextMonthSide").on("click", function () {
      //navegarMes(1);
    });

    // Botones de mes (delegación, contenido dinámico)
    els.monthList.on("click", "[data-month]", function () {
      state.mesActivo = Number($(this).data("month"));
      render();
    });


    els.searchInput.on("input", function () {
      state.busqueda = $(this).val();
      //els.clearSearch.toggleClass("hidden", !state.busqueda);
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

    // Días con citas: toggle de estado, menú, eliminar (delegación)
    els.daysList.on("click", '[data-action="toggle-status"]', function () {
      toggleEstado(Number($(this).data("day")), $(this).data("id"));
    });

    els.daysList.on("click", '[data-action="menu"]', function (e) {
      e.stopPropagation();
      closeMenus();
      $("#menu-" + $(this).data("id")).toggleClass("hidden");
    });

    els.daysList.on("click", '[data-action="delete"]', function () {
      eliminarCita(Number($(this).data("day")), $(this).data("id"));
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

  /* ------------------------- Inicialización ------------------------- */
  els.generoInput.html(
    sexoLista
      .map(function (p) {
        return (
          '<option value="' +
          escapeHtml(p) +
          '">' +
          escapeHtml(p) +
          "</option>"
        );
      })
      .join(""),
  );

  bindEvents();
  render();
})(jQuery);
