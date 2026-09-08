(function ($) {
  "use strict";

  /* ------------------------- Constantes ------------------------- */
  let meses = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];

  let mesesLargos = [
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

  const ESTADO_TEXT = {
    CONFIRMADA: "Confirmada",
    PENDIENTE: "Pendiente",
    CANCELADA: "Cancelada"
  };

  let citaId = 0;
  let mkId = function () {
    return "cita-" + ++citaId;
  };

  let data_response = [];

  let colorClass = [
    "bg-blue-200",
    "bg-plomo-200",
    "bg-slate-200",
    "bg-white-200",
    "bg-sky-200",
    "bg-stone-200",
    "bg-teal-200",
    "bg-neutral-200",
    "bg-green-200",
    "bg-slate-300",
  ];

  let estadoClass = {
    Confirmada: {
      dot: "bg-emerald-500",
      text: "text-emerald-700",
      hover: "hover:bg-emerald-200",
      value: "Confirmar",
      icon: "check-circle"
    },
    Pendiente: {
      dot: "bg-amber-500",
      text: "text-amber-700",
      hover: "hover:bg-amber-200",
      value: "Pendiente",
      icon: "clock-3"
    },
    Cancelada: {
      dot: "bg-red-400",
      text: "text-red-600",
      hover: "hover:bg-red-200",
      value: "Cancelar",
      icon: "x-circle"
    },
  };

  /* ------------------------- Estado ------------------------- */
  let currentDate = new Date();

  let state = {
    mesActivo: currentDate.getMonth(),
    mesActivoSide: currentDate.getMonth(),
    calendario: [],
    colorSeleccionado: "bg-blue-200",
    busqueda: "",
  };

  /* ------------------------- Nodos ------------------------- */
  let els = {
    monthList: $("#monthList"),
    daysList: $("#daysList"),
    miniMonthTitle: $("#miniMonthTitle"),
    miniCalendar: $("#miniCalendar"),
    upcomingList: $("#upcomingList"),
    searchInput: $("#searchInput"),
    searchButton: $("#searchButton"),
    cancelSearch: $("#cancelSearch"),

    modalBackdrop: $("#modalBackdrop"),
    formError: $("#formError"),
    modalNota: $("#modalNota"),
    closeModalNota: $("#closeModalNota"),
    notaCompleta: $("#notaCompleta"),
  };

  let formulario = {
    patientInput: $("#patientInput"),
    patientLansnameInput: $("#patientLasnameInput"),
    generoInput: $("#generoInput"),
    generoOtroInput: $("#gneroOtroInput"),
    timeInput: $("#timeInput"),
    dateInput: $("#dateInput"),
    timeMaxInput: $("#timeMaxInput"),
    notaInput: $("#notaInput"),
    telefonoInput: $("#telefonoInput"),
    estadoInput: $("#estadoInput"),
    coloresButtons: $("#coloresButtons"),
  };

  /* ------------------------- Utilidades ------------------------- */
  function inicialesDe(nombre) {
    let partes = String(nombre).split(" ");
    let letras = partes.map(function (n) {
      return n[0] || "";
    });
    return letras.join("").slice(0, 2).toUpperCase();
  }
  function escapeHtml(value) {
    return String(value)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/\"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }
  function formatHour(hourStr) {
    if (!hourStr) return "";
    let [hours] = hourStr.split(':').map(Number);
    let ampm = hours >= 12 ? 'PM' : 'AM';
    return hourStr + ' ' + ampm;
  }

  function hydrateIcons() {
    if (window.lucide) {
      lucide.createIcons();
    }
  }

  function totalCitas(estado, monthSelected) {
    let now = new Date();
    let targetAbsoluteMonth = now.getFullYear() * 12 + monthSelected;
    let currentMonthNow = now.getMonth();
    let currentYearNow = now.getFullYear();
    let currentDayNow = now.getDate();

    return state.calendario
      .filter(function (item) {
        let d = new Date(item.date);
        return (d.getFullYear() * 12 + d.getMonth()) === targetAbsoluteMonth;
      })
      .reduce(function (total, item) {
        let itemDate = new Date(item.date);
        return total + item.citas.filter(function (cita) {
          if (itemDate.getFullYear() === currentYearNow && itemDate.getMonth() === currentMonthNow) {
            return itemDate.getDate() >= currentDayNow && cita.estado === estado;
          }
          return cita.estado === estado;
        }).length;
      }, 0);
  }

  function diasConCita(monthSelected) {
    let now = new Date();
    let targetAbsoluteMonth = now.getFullYear() * 12 + monthSelected;

    return state.calendario
      .filter(function (item) {
        if (!item.citas || item.citas.length === 0) {
          return false;
        }
        let d = new Date(item.date);
        return (d.getFullYear() * 12 + d.getMonth()) === targetAbsoluteMonth;
      })
      .map(function (item) {
        return item;
      });
  }

  function citasFiltradas(month) {
    let q = state.busqueda.trim().toLowerCase();

    let filteredByMonth = state.calendario.filter(function (item) {
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
    let items = [];
    let now = new Date();
    let currentMonthNow = now.getMonth();
    let currentDayNow = now.getDate();
    let targetAbsoluteMonth = now.getFullYear() * 12 + monthSelected;

    state.calendario.forEach(function (element) {
      let date = new Date(element.date);
      if ((date.getFullYear() * 12 + date.getMonth()) === targetAbsoluteMonth) {
        element.citas.forEach(function (cita) {
          if (currentMonthNow == date.getMonth() && now.getFullYear() == date.getFullYear()) {
            if (date.getDate() >= currentDayNow) {
              items.push({ cita: cita, dia: date.getDate() });
            }
          }
          else {
            items.push({ cita: cita, dia: date.getDate() });
          }
        });
      }
    });

    return items;
  }

  function renderMonths() {
    let now = new Date();
    let currentMonth = now.getMonth();
    let currentYear = now.getFullYear();

    let monthsToRender = [];
    for (let i = -3; i <= 3; i++) {
      let date = new Date(currentYear, currentMonth + i, 1);
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

  function getHtmlBottonOption(id, estadoRegistro, estado) {
    if (estadoRegistro == estado) {
      return '';
    }
    let status = estadoClass[estado];
    const html = `<button
               type="button"
               data-action="update-status"
               data-id="${id}"
               data-status="${estado}"
               class="flex w-full rounded-full items-center gap-1 px-2 py-1 text-left text-xs font-medium ${status.text} transition ${status.hover}">
               <i data-lucide="${status.icon}" class="h-[13px] w-[13px]"></i>
               ${status.value}
           </button>`
    return html;
  }

  function getHtmlModalOption(cita, dia, idRefence) {
    const btn1 = getHtmlBottonOption(cita.id, cita.estado, ESTADO_TEXT.CONFIRMADA);
    const btn2 = getHtmlBottonOption(cita.id, cita.estado, ESTADO_TEXT.PENDIENTE);
    const btn3 = getHtmlBottonOption(cita.id, cita.estado, ESTADO_TEXT.CANCELADA);
    let bottom = "5";
    if (idRefence == "menu-mini-") {
      bottom = "1";
    }
    const html = `<div id="${idRefence}` +
      cita.id +
      '" class="absolute bottom-' + bottom + ' justify-items-center z-20 hidden w-36 h-auto rounded-lg border border-slate-300 bg-slate-100 py-1 shadow-lg">' +
      '<button type="button" data-action="edit" data-id="' +
      cita.id +
      '"' +
      ' class="flex rounded-full items-center m-2 gap-2 px-3 py-2 text-left text-xs font-medium text-amber-600 transition hover:bg-amber-200">' +
      '<i data-lucide="edit-2" class="h-[13px] w-[13px]"></i>Editar Cita' +
      "</button>" +
      '<button type="button" data-action="delete" data-id="' +
      cita.id +
      '"' +
      ' class="flex rounded-full items-center m-2 gap-2 px-3 py-2 text-left text-xs font-medium text-red-600 transition hover:bg-red-200">' +
      '<i data-lucide="trash-2" class="h-[13px] w-[13px]"></i>Eliminar Cita' +
      "</button>" +
      `<div class="flex flex-col gap-2 border-t border-slate-300 px-2 py-3">
      ${btn1}
      ${btn2}
      ${btn3}
      </div>`+
      "</div>";
    return html;
  }

  function appointmentCard(cita, day) {
    let status = estadoClass[cita.estado];

    const optionModal = getHtmlModalOption(cita, day, "menu-");

    if (!cita.nota) {
      cita.nota = "- - - - - - - - - - - - - -";
    }
    return (
      '<article class="border border-slate-300 ' +
      cita.color +
      ' overflow-visible min-w-[180px] max-w-[180px] rounded-xl p-2.5 shadow-sm sm:min-w-[188px]">' +
      '<div class="flex items-start gap-2 px-0.5 pb-2">' +
      '<span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-200 bg-white text-xs font-semibold text-slate-800 shadow-sm">' +
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
      '<div class="flex items-center gap-2 rounded-lg bg-white/90 px-2 py-2 shadow-xs cursor-pointer border border-slate-200" onclick="abrirModalNota(`' + escapeHtml(cita.nota) + '`)">' +
      '<span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-slate-50 text-slate-800">' +
      '<i data-lucide="clipboard-list" class="h-3.5 w-3.5"></i>' +
      "</span>" +
      '<p class="truncate text-xs font-semibold text-slate-900 w-max-10">' +
      escapeHtml(cita.nota) +
      "</p>" +
      "</div>" +
      '<div class="relative flex items-center justify-between gap-1 pt-2 text-xs font-medium">' +
      '<button type="button" class=" border border-slate-200 flex items-center gap-1 rounded-full bg-white/90 px-2 py-1 text-slate-700">' +
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
      optionModal +
      "</div>" +
      "</article>"
    );
  }

  function renderDays() {
    let days = citasFiltradas(state.mesActivoSide);

    if (days.length == 0) {
      els.daysList.html(
        [1].map(function (item) {
          let inner =
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
          let inner;
          const fecha = new Date(item.date);
          const dia = fecha.getDate();

          if (item.citas.length) {
            inner =
              '<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 pb-1">' +
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

  function sonTodasEstadoDelDia(estado, citas) {
    let result = true;
    citas.forEach(element => {
      if (element.estado != estado) {
        result = false;
      }
    });
    return result;
  }

  function renderMiniCalendar() {
    let year = currentDate.getFullYear();
    let month = currentDate.getMonth();

    let total = totalCitas(ESTADO_TEXT.CONFIRMADA, month);
    let totalPendientes = totalCitas(ESTADO_TEXT.PENDIENTE, month);

    let firstDayOfMonth = new Date(year, month, 1).getDay();
    let daysInMonth = new Date(year, month + 1, 0).getDate();

    let firstDayAdjusted = firstDayOfMonth === 0 ? 6 : firstDayOfMonth - 1;

    let calendario = [];
    let prevMonthLastDay = new Date(year, month, 0).getDate();

    for (let i = firstDayAdjusted - 1; i >= 0; i--) {
      calendario.push(prevMonthLastDay - i);
    }
    for (let i = 1; i <= daysInMonth; i++) {
      calendario.push(i);
    }
    let remaining = 42 - calendario.length;
    for (let i = 1; i <= remaining; i++) {
      calendario.push(i);
    }

    let weekDays = ["Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"];
    let appointmentDays = diasConCita(month);

    let html = "";

    html += '<div class="mt-5">';
    html +=
      '<div class="grid grid-cols-7 gap-y-2 text-center text-xs font-bold text-slate-800">';
    html += weekDays
      .map(function (d) {
        return "<span>" + d + "</span>";
      })
      .join("");

    calendario.forEach(function (day, index) {

      let outside = index < firstDayAdjusted || index >= firstDayAdjusted + daysInMonth;

      let appointmentDay = appointmentDays.find(function (item) {
        const fecha = new Date(item.date);
        return fecha.getDate() === day;
      });

      let hasAppointment = appointmentDay !== undefined && !outside;

      let colorMark = "bg-red-500";

      if (hasAppointment && sonTodasEstadoDelDia(ESTADO_TEXT.PENDIENTE, appointmentDay.citas)) {

        colorMark = "bg-orange-500";
      }
      else if (hasAppointment && sonTodasEstadoDelDia(ESTADO_TEXT.CANCELADA, appointmentDay.citas)) {
        colorMark = "bg-white";
      }

      const currentDateNow = new Date();
      const currentMonthNow = currentDateNow.getMonth();
      const currentDayNow = currentDateNow.getDate();
      if (month <= currentMonthNow) {

        if (day < currentDayNow) {
          colorMark = "bg-slate-500";
        }
        else if (month < currentMonthNow) {
          colorMark = "bg-slate-500";
        }
      }
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
    let status = estadoClass[cita.estado];
    const optionModal = getHtmlModalOption(cita, dia, "menu-mini-");
    return (
      '<div class="border border-slate-300  ' +
      cita.color +
      ' flex items-center gap-3 rounded-xl p-3.5">' +
      '<span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white border border-slate-200 text-xs font-semibold">' +
      inicialesDe(cita.nombre_paciente) +
      "</span>" +
      '<div class="min-w-0 flex-1">' +
      '<p class="text-xs font-semibold">' +
      escapeHtml(cita.nombre_paciente) + " " + escapeHtml(cita.apellido_paciente) +
      "</p>" +
      '<p class="mt-0.5 max-w-180 truncate text-xs text-slate-600 cursor-pointer " onclick="abrirModalNota(`' + escapeHtml(cita.nota) + '`)">' +
      escapeHtml(cita.nota) +
      "</p>" +
      '<p class="mt-0.5 text-xs text-slate-700 font-semibold">' +
      dia +
      " " +
      meses[state.mesActivo] +
      " · " +
      escapeHtml(formatHour(cita.hora)) +
      "</p>" +
      "</div>" +
      '<div class="flex flex-col items-end gap-2">' +
      '<span class="flex items-center gap-1 rounded-full bg-white border border-slate-200 px-2 py-0.5 text-xs font-semibold ' +
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
      optionModal +

      "</div>" +
      "</div>"
    );
  }

  function renderUpcoming() {//proximas citas
    let items = proximasCitas(state.mesActivo);

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
    formulario.coloresButtons.html(
      colorClass
        .map(function (color) {

          return (
            '<button type="button" data-form-day="' +
            color +
            '"' +
            ' class="h-7 w-7 rounded-full text-xs font-medium transition ' +
            (state.colorSeleccionado == color
              ? color + " border border-slate-600 animate-bounce "
              : color + " border border-slate-300") +
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
        let dateA = new Date(a.date);
        let dateB = new Date(b.date);
        return dateA - dateB;
      });
  }

  /* ------------------------- Data Fetching ------------------------- */
  function fetchGetHistory() {
    let idUser = $("#idUser").val().trim();
    $.ajax({
      url: window.APP_CONFIG.localhost + '/api/enpoint_calendary.php',
      type: 'GET',
      data: { search: state.busqueda, idUser: idUser },
      dataType: 'json',
      success: function (data) {

        state.calendario = data.map(function (item) {
          return {
            date: new Date(item.date + "T00:00:00"),
            citas: [
              {
                id: item.id,
                idUser: item.id_user,
                nombre_paciente: item.nombre,
                apellido_paciente: item.apellidos,
                sexo: item.sexo,
                id_patient: item.id_patient,
                telefono: item.telefono,
                nota: item.nota,
                hora: item.hora.slice(0, 5),
                color: item.color,
                duracion: item.duracion,
                estado: item.estado,
              }
            ]
          };
        });

        let grouped = {};
        state.calendario.forEach(function (item) {
          let dateStr = item.date.toDateString();
          if (!grouped[dateStr]) {
            grouped[dateStr] = { date: item.date, citas: [] };
          }
          grouped[dateStr].citas.push(item.citas[0]);
        });
        state.calendario = Object.values(grouped);

        render();
      },
      error: function (err) {
        console.error(err);
      }
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

    let newDate = new Date(currentDate);
    newDate.setMonth(newDate.getMonth() + delta);
    currentDate = newDate;

    render();
  }

  /* ------------------------- Modal ------------------------- */
  function abrirModal() {
    els.formError.addClass("hidden");
    els.modalBackdrop.removeClass("hidden").addClass("flex");
    setTimeout(function () {
      formulario.patientInput.trigger("focus");
    }, 0);
  }

  function cerrarModal() {
    els.modalBackdrop.addClass("hidden").removeClass("flex");
    els.formError.addClass("hidden");
  }

  window.abrirModalNota = function (texto) {
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
  function guardarCita() {
    let idCita = $("#appointmentId").val();
    let id_patient = $("#id_patient").val();
    let nombre_paciente = formulario.patientInput.val().trim();
    let apellido_paciente = formulario.patientLansnameInput.val().trim();
    let genero = formulario.generoInput.val();
    let hora = formulario.timeInput.val().trim();
    let fecha = formulario.dateInput.val();
    let estado = formulario.estadoInput.val();
    let duracion = formulario.timeMaxInput.val().trim();
    let nota = formulario.notaInput.val();
    let telefono = formulario.telefonoInput.val().trim();
    let idUser = $("#idUser").val().trim();

    if (genero === "Otro") {
      genero = formulario.generoOtroInput.val().trim();
    }

    if (!nombre_paciente || !apellido_paciente || !hora || !fecha || !genero || !estado || !duracion) {
      mostrarError("Por favor completa todos los campos.");
      return;
    }

    let color = state.colorSeleccionado;

    if (!idCita) {
      // Lógica de nueva cita (Agregar)
      let nuevaCita = {
        id: mkId(),
        idUser: idUser,
        nombre_paciente: nombre_paciente,
        apellido_paciente: apellido_paciente,
        sexo: genero,
        telefono: telefono,
        hora: hora,
        color: color,
        duracion: duracion,
        estado: estado,
        nota: nota,
      };

      let dateObj = new Date(fecha + "T00:00:00");
      let existingDay = state.calendario.find(function (item) {
        return new Date(item.date).toDateString() === dateObj.toDateString();
      });

      if (existingDay) {
        existingDay.citas.push(nuevaCita);
      } else {
        state.calendario.push({
          date: dateObj,
          citas: [nuevaCita]
        });
      }

      $.post(window.APP_CONFIG.localhost + '/api/enpoint_calendary.php', {
        action: 'add-calendary',
        idUser: idUser,
        nombre_paciente: nombre_paciente,
        apellido_paciente: apellido_paciente,
        sexo: genero,
        telefono: telefono,
        date: fecha,
        hora: hora,
        duracion: duracion,
        color: color,
        estado: estado,
        nota: nota
      });
      formulario.patientInput.val("");
      formulario.patientLansnameInput.val("");
      formulario.generoInput.val("");
      formulario.generoOtroInput.val("");
      formulario.timeInput.val("");
      formulario.dateInput.val("");
      formulario.timeMaxInput.val("");
      formulario.telefonoInput.val("");
      formulario.notaInput.val("");
      $("#appointmentId").val("");
      state.colorSeleccionado = "bg-blue-200";

      cerrarModal();
      render();
    } else {
      
      $.post(window.APP_CONFIG.localhost + '/api/enpoint_calendary.php', {
        action: 'update-calendary',
        id: idCita,
        id_patient:id_patient,
        nombre_paciente: nombre_paciente,
        apellido_paciente: apellido_paciente,
        sexo: genero,
        telefono: telefono,
        date: fecha,
        hora: hora,
        duracion: duracion,
        color: color,
        estado: estado,
        nota: nota
      });
      location.reload();
    }


  }

  function editarCita(id) {
    // Buscar la cita en el estado actual
    let citaEncontrada = null;
    state.calendario.forEach(function (item) {
      let cita = item.citas.find(c => c.id == id);
      if (cita) citaEncontrada = cita;
    });

    if (!citaEncontrada) return;

    // 1. Asignar ID de la cita al campo oculto
    $("#appointmentId").val(citaEncontrada.id);

    $("#id_patient").val(citaEncontrada.id_patient);

    // 2. Rellenar el formulario con los datos de la cita
    formulario.patientInput.val(citaEncontrada.nombre_paciente);
    formulario.patientLansnameInput.val(citaEncontrada.apellido_paciente);
    formulario.generoInput.val(citaEncontrada.sexo);
    if (citaEncontrada.sexo === "Otro") {
      formulario.generoOtroInput.removeClass("hidden");
    } else {
      formulario.generoOtroInput.addClass("hidden");
    }
    formulario.telefonoInput.val(citaEncontrada.telefono);

    // Formatear fecha para el input type="date" (YYYY-MM-DD)
    let dateObj = new Date(state.calendario.find(i => i.citas.some(c => c.id == id)).date);
    let fechaStr = dateObj.toISOString().split('T')[0];
    formulario.dateInput.val(fechaStr);

    formulario.timeInput.val(citaEncontrada.hora);
    formulario.timeMaxInput.val(citaEncontrada.duracion);
    formulario.estadoInput.val(citaEncontrada.estado);
    formulario.notaInput.val(citaEncontrada.nota);
    state.colorSeleccionado = citaEncontrada.color;
    renderFormDays();
    //Abrir modal
    $("#openModal").on("click", abrirModal);
    abrirModal();
    // Cambiar título del modal
    $("#modalBackdrop h2").text("Editar Cita");
  }

  function eliminarCita(id) {
    state.calendario = state.calendario.map(function (item) {
      return {
        ...item,
        citas: item.citas.filter(function (cita) {
          return cita.id != id;
        })
      };
    });
    render();

    $.post(window.APP_CONFIG.localhost + '/api/enpoint_calendary.php', {
      action: 'remove',
      id: id
    });
  }

  function closeMenus() {
    $('[id^="menu-"]').addClass("hidden");
    $('[id^="menu-mini-"]').addClass("hidden");
  }

  function actualizarEstadoCita(id, nuevoEstado) {
    state.calendario = state.calendario.map(function (item) {
      return {
        ...item,
        citas: item.citas.map(function (cita) {
          if (cita.id == id) {
            return { ...cita, estado: nuevoEstado };
          }
          return cita;
        })
      };
    });
    render();

    $.post(window.APP_CONFIG.localhost + '/api/enpoint_calendary.php', {
      action: 'update_status',
      id: id,
      status: nuevoEstado
    });
  }

  /* ------------------------- Eventos ------------------------- */
  function bindEvents() {
    // Modal
    $("#openModal").on("click", abrirModal);
    $("#closeModal").on("click", cerrarModal);
    $("#saveAppointment").on("click", guardarCita);

    els.closeModalNota.on("click", cerrarModalNota);
    els.modalNota.on("click", function (e) {
      if (e.target === this) {
        cerrarModalNota();
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
    });
    els.searchButton.on("click", function () {
      fetchGetHistory();
    });

    els.cancelSearch.on("click", function () {
      state.busqueda = "";
      els.searchInput.val("");
      fetchGetHistry();
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

    els.daysList.on("click", '[data-action="edit"]', function () {
      editarCita($(this).data("id"));
    });
    els.upcomingList.on("click", '[data-action="edit"]', function () {
      editarCita($(this).data("id"));
    });

    $(document).on("click", '[data-action="update-status"]', function () {
      var id = $(this).data("id");
      var nuevoEstado = $(this).data("status");
      actualizarEstadoCita(id, nuevoEstado);
    });
    // Mini calendario (delegación)
    els.miniCalendar.on("click", "[data-mini-day]", function () {
      let day = Number($(this).data("miniDay"));
      let year = currentDate.getFullYear();
      let month = currentDate.getMonth();

      let selectedDate = new Date(year, month, day);
      let dateString = selectedDate.toISOString().split('T')[0];

      $("#dateInput").val(dateString);
      abrirModal();
    });

    // Mostrar/Ocultar campo "Otro" género
    formulario.generoInput.on("change", function () {
      if ($(this).val() === "Otro") {
        formulario.generoOtroInput.removeClass("hidden");
      } else {
        formulario.generoOtroInput.addClass("hidden");
      }
    });

    // Días del formulario (delegación)
    formulario.coloresButtons.on("click", "[data-form-day]", function () {
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
  fetchGetHistory();
  render();
})(jQuery);
