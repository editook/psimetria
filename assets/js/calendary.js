/* ========================================================================
 * calendary.js — Versión jQuery (reescrito)
 *
 * Calendario de citas de PSYMETRIA.
 * Requiere jQuery (assets/plugins/jquery/jquery.min.js) y
 * Lucide hereditable (assets/js/vendor/lucide.min.js).
 *
 * Ventajas sobre la versión vanilla:
 *  - Delegación de eventos para todo el HTML renderizado dinámicamente.
 *  - Código más corto y legible (selectores $, .html(), .on()).
 *  - Compatible con navegadores antiguos (sin replaceAll / flatMap).
 * ================================================================= */
(function ($) {
  'use strict';

  /* ------------------------- Constantes ------------------------- */
  var meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul'];//,'Ago','Sep','Oct','Nov','Dic'



  
  var mesesLargos = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio'];

  var pruebasLista = ['MCMI-IV', 'MACI', 'AF 2.2', 'CMASR-2 2.0'];

  var duracionPorPrueba = {
    'CMASR-2 2.0': '30 min',
    'AF 2.2': '45 min',
    'MACI': '60 min',
    'MCMI-IV': '90 min'
  };

  var citaId = 0;
  var mkId = function () {
    return 'cita-' + (++citaId);
  };

  var diasIniciales = [
    { day: 1, citas: [{ id: mkId(), paciente: 'María López', prueba: 'MCMI-IV', hora: '8:00 am', color: 'lavender', duracion: '90 min', estado: 'Confirmada' }] },
    { day: 2, citas: [] },
    {
      day: 3,
      citas: [
        { id: mkId(), paciente: 'Carlos Ruiz', prueba: 'MACI', hora: '8:00 am', color: 'coral', duracion: '60 min', estado: 'Confirmada' },
        { id: mkId(), paciente: 'Ana Torres', prueba: 'MCMI-IV', hora: '9:00 am', color: 'lavender', duracion: '90 min', estado: 'Pendiente' },
        { id: mkId(), paciente: 'Luis Gómez', prueba: 'AF 2.2', hora: '10:00 am', color: 'mint', duracion: '45 min', estado: 'Confirmada' }
      ]
    },
    { day: 4, citas: [] },
    { day: 5, citas: [{ id: mkId(), paciente: 'Sofía Díaz', prueba: 'CMASR-2 2.0', hora: '11:00 am', color: 'cream', duracion: '30 min', estado: 'Confirmada' }] },
    { day: 6, citas: [{ id: mkId(), paciente: 'Pedro Martín', prueba: 'AF 2.2', hora: '8:00 am', color: 'mint', duracion: '45 min', estado: 'Pendiente' }] }
  ];

  var colores = ['lavender', 'coral', 'mint', 'cream'];

  var colorClass = {
    lavender: 'bg-lavender',
    coral: 'bg-coral',
    mint: 'bg-mint',
    cream: 'bg-cream'
  };

  var siguienteEstado = {
    Confirmada: 'Pendiente',
    Pendiente: 'Cancelada',
    Cancelada: 'Confirmada'
  };

  var estadoClass = {
    Confirmada: {
      dot: 'bg-emerald-500',
      text: 'text-emerald-700'
    },
    Pendiente: {
      dot: 'bg-amber-500',
      text: 'text-amber-700'
    },
    Cancelada: {
      dot: 'bg-red-400',
      text: 'text-red-600'
    }
  };

  /* ------------------------- Estado ------------------------- */
  var state = {
    mesActivo: 1,
    paciente: '',
    prueba: 'MCMI-IV',
    hora: '',
    citas: JSON.parse(JSON.stringify(diasIniciales)),
    diaSeleccionado: 3,
    busqueda: '',
    busquedaActiva: false
  };

  /* ------------------------- Nodos ------------------------- */
  var els = {
    monthList: $('#monthList'),
    daysList: $('#daysList'),
    miniMonthTitle: $('#miniMonthTitle'),
    miniCalendar: $('#miniCalendar'),
    upcomingList: $('#upcomingList'),
    searchBar: $('#searchBar'),
    searchInput: $('#searchInput'),
    clearSearch: $('#clearSearch'),
    cancelSearch: $('#cancelSearch'),
    modalBackdrop: $('#modalBackdrop'),
    patientInput: $('#patientInput'),
    testInput: $('#testInput'),
    timeInput: $('#timeInput'),
    dayButtons: $('#dayButtons'),
    formError: $('#formError')
  };

  /* ------------------------- Utilidades ------------------------- */
  function inicialesDe(nombre) {
    var partes = String(nombre).split(' ');
    var letras = partes.map(function (n) { return (n[0] || ''); });
    return letras.join('').slice(0, 2).toUpperCase();
  }

  function escapeHtml(value) {
    return String(value)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function hydrateIcons() {
    if (window.lucide) {
      lucide.createIcons();
    }
  }

  function totalCitas() {
    return state.citas.reduce(function (acc, day) {
      return acc + day.citas.length;
    }, 0);
  }

  function diasConCita() {
    return state.citas
      .filter(function (day) { return day.citas.length > 0; })
      .map(function (day) { return day.day; });
  }

  function citasFiltradas() {
    var q = state.busqueda.trim().toLowerCase();

    if (!q) {
      return state.citas;
    }

    return state.citas.map(function (day) {
      return {
        day: day.day,
        citas: day.citas.filter(function (cita) {
          return cita.paciente.toLowerCase().indexOf(q) !== -1 ||
                 cita.prueba.toLowerCase().indexOf(q) !== -1;
        })
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
    els.monthList.html(meses.map(function (mes, i) {
      return (
        '<button type="button"' +
        ' class="h-8 min-w-[85px] shrink-0 rounded-full text-xs font-medium transition ' +
        (state.mesActivo === i ? 'bg-black text-white shadow-sm' : 'bg-slate-50 text-slate-700 hover:bg-slate-100') +
        '" data-month="' + i + '">' +
        mes +
        '</button>'
      );
    }).join(''));
  }

  function appointmentCard(cita, day) {
    var status = estadoClass[cita.estado];

    return (
      '<article class="' + colorClass[cita.color] + ' min-w-[180px] rounded-xl p-2.5 shadow-sm sm:min-w-[188px]">' +
        '<div class="flex items-start gap-2 px-0.5 pb-2">' +
          '<span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-xs font-semibold text-slate-800 shadow-sm">' +
            inicialesDe(cita.paciente) +
          '</span>' +
          '<div class="min-w-0 flex-1 pt-0.5">' +
            '<p class="truncate text-sm font-semibold text-slate-900">' + escapeHtml(cita.paciente) + '</p>' +
            '<p class="text-xs text-slate-600">' + escapeHtml(cita.hora) + ' · ' + escapeHtml(cita.duracion) + '</p>' +
          '</div>' +
        '</div>' +
        '<div class="flex items-center gap-2 rounded-lg bg-white/90 px-2 py-2 shadow-sm">' +
          '<span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-slate-50 text-slate-800">' +
            '<i data-lucide="clipboard-list" class="h-3.5 w-3.5"></i>' +
          '</span>' +
          '<p class="truncate text-xs font-semibold text-slate-900">' + escapeHtml(cita.prueba) + '</p>' +
        '</div>' +
        '<div class="relative flex items-center justify-between gap-1 pt-2 text-xs font-medium">' +
          '<button type="button" data-action="toggle-status" data-day="' + day + '" data-id="' + cita.id + '"' +
            ' class="flex items-center gap-1 rounded-full bg-white/90 px-2 py-1 text-slate-700 transition hover:bg-white">' +
            '<span class="h-1.5 w-1.5 rounded-full ' + status.dot + '"></span>' +
            '<span class="' + status.text + '">' + cita.estado + '</span>' +
          '</button>' +
          '<span class="flex items-center gap-1 rounded-full bg-white/90 px-2 py-1 text-slate-700">' +
            '<i data-lucide="user" class="h-2.5 w-2.5"></i>1' +
          '</span>' +
          '<button type="button" data-action="menu" data-id="' + cita.id + '"' +
            ' class="rounded p-1 text-slate-800 transition hover:bg-black/10" aria-label="Más opciones">' +
            '<i data-lucide="ellipsis" class="h-[15px] w-[15px]"></i>' +
          '</button>' +
          '<div id="menu-' + cita.id + '" class="absolute bottom-9 right-0 z-20 hidden w-36 rounded-lg border border-slate-100 bg-red-50 py-1 shadow-lg">' +
            '<button type="button" data-action="delete" data-day="' + day + '" data-id="' + cita.id + '"' +
              ' class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-medium text-red-600 transition hover:bg-red-50">' +
              '<i data-lucide="trash-2" class="h-[13px] w-[13px]"></i>Eliminar cita' +
            '</button>' +
          '</div>' +
        '</div>' +
      '</article>'
    );
  }
function renderDays() {
    var days = citasFiltradas();

    els.daysList.html(days.map(function (day) {
      var inner;

      if (day.citas.length) {
        inner = '<div class="flex gap-2 overflow-x-auto pb-1">' +
          day.citas.map(function (cita) { return appointmentCard(cita, day.day); }).join('') +
          '</div>';
      } else {
        inner = '<div class="pt-1 text-xs text-slate-400">' +
          (state.busqueda ? 'Sin resultados.' : 'Sin citas.') +
          '</div>';
      }

      return (
        '<div class="grid min-h-[82px] grid-cols-[30px_minmax(0,1fr)] gap-3 px-5 py-4 sm:grid-cols-[38px_minmax(0,1fr)] sm:px-8 ' +
        (state.diaSeleccionado === day.day ? 'bg-slate-50/60' : '') + '">' +
          '<div class="pt-1 text-xs font-semibold text-slate-800">' + day.day + '</div>' +
          inner +
        '</div>'
      );
    }).join(''));
  }
function renderMiniCalendar() {
    var calendario = [27, 28, 29, 30, 31, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 1, 2];
    var weekDays = ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'];
    var appointmentDays = diasConCita();
    var html = '';

    html += '<div class="mt-5">';
    html += '<div class="grid grid-cols-7 gap-y-2 text-center text-xs font-semibold text-slate-500">';
    html += weekDays.map(function (d) { return '<span>' + d + '</span>'; }).join('');

    calendario.forEach(function (day, index) {
      var outside = index < 5 || index > 32;
      var hasAppointment = appointmentDays.indexOf(day) !== -1 && !outside;
      var selected = day === state.diaSeleccionado && !outside;

      html += '<button type="button"' +
        (outside ? ' disabled' : '') +
        ' data-mini-day="' + day + '"' +
        ' class="relative mx-auto flex h-7 w-7 items-center justify-center rounded-full text-xs font-medium transition ' +
        (selected ? 'bg-black text-white' : '') + ' ' +
        (outside
          ? 'cursor-default text-slate-300'
          : 'cursor-pointer text-slate-700 hover:bg-slate-100') + '">' +
        day +
        (hasAppointment
          ? '<i class="absolute bottom-0.5 h-1 w-1 rounded-full ' + (selected ? 'bg-white' : 'bg-violet-500') + '"></i>'
          : '') +
        '</button>';
    });

    html += '</div>';
    html += '<div class="mt-4 flex items-center gap-2 text-xs text-slate-600">';
    html += '<span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span>Citas programadas';
    html += '</div>';
    html += '</div>';

    els.miniCalendar.html(html);
  }
function upcomingCard(cita, day) {
    var status = estadoClass[cita.estado];

    return (
      '<div class="' + colorClass[cita.color] + ' flex items-start gap-3 rounded-xl p-3.5">' +
        '<span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-xs font-semibold">' +
          inicialesDe(cita.paciente) +
        '</span>' +
        '<div class="min-w-0 flex-1">' +
          '<p class="text-xs font-semibold">' + escapeHtml(cita.prueba) + '</p>' +
          '<p class="mt-0.5 text-xs text-slate-600">' + escapeHtml(cita.paciente) + '</p>' +
          '<p class="mt-0.5 text-xs text-slate-500">' + day + ' ' + meses[state.mesActivo] + ' · ' + escapeHtml(cita.hora) + '</p>' +
        '</div>' +
        '<div class="flex flex-col items-end gap-2">' +
          '<span class="flex items-center gap-1 rounded-full bg-white px-2 py-0.5 text-xs font-semibold ' + status.text + '">' +
            '<span class="h-1.5 w-1.5 rounded-full ' + status.dot + '"></span>' + cita.estado +
          '</span>' +
          '<i data-lucide="ellipsis" class="h-[15px] w-[15px] text-slate-800 cursor-pointer"></i>' +
        '</div>' +
      '</div>'
    );
  }

  function renderUpcoming() {
    var items = proximasCitas();

    els.upcomingList.html(items.length
      ? '<div class="space-y-3">' + items.map(function (x) { return upcomingCard(x.cita, x.day); }).join('') + '</div>'
      : '<p class="text-xs text-slate-400">No hay citas programadas.</p>');
  }
function renderFormDays() {
    els.dayButtons.html([1, 2, 3, 4, 5, 6].map(function (day) {
      return (
        '<button type="button" data-form-day="' + day + '"' +
        ' class="h-7 w-7 rounded-full text-xs font-medium transition ' +
        (state.diaSeleccionado === day
          ? 'bg-black text-white'
          : 'bg-slate-50 text-slate-700 hover:bg-slate-100') + '">' +
        day +
        '</button>'
      );
    }).join(''));
  }
function render() {
    renderMonths();

    var total = totalCitas();
    els.miniMonthTitle.text(mesesLargos[state.mesActivo]);

    renderDays();
    renderMiniCalendar();
    renderUpcoming();
    renderFormDays();

    hydrateIcons();
  }
function navegarMes(delta) {
    state.mesActivo = Math.max(0, Math.min(meses.length - 1, state.mesActivo + delta));
    render();
  }

  /* ------------------------- Modal ------------------------- */
  function abrirModal() {
    els.formError.addClass('hidden');
    els.modalBackdrop.removeClass('hidden').addClass('flex');
    setTimeout(function () {
      els.patientInput.trigger('focus');
    }, 0);
  }

  function cerrarModal() {
    els.modalBackdrop.addClass('hidden').removeClass('flex');
    els.formError.addClass('hidden');
  }

  function mostrarError(message) {
    els.formError.text(message).removeClass('hidden');
  }

  /* ------------------------- Acciones de cita ------------------------- */
  function agregarCita() {
    var paciente = els.patientInput.val().trim();
    var prueba = els.testInput.val();
    var hora = els.timeInput.val().trim();

    if (!paciente || !hora) {
      mostrarError('Por favor completa todos los campos.');
      return;
    }

    var color = colores[Math.floor(Math.random() * colores.length)];

    var nuevaCita = {
      id: mkId(),
      paciente: paciente,
      prueba: prueba,
      hora: hora,
      color: color,
      duracion: duracionPorPrueba[prueba] || '60 min',
      estado: 'Pendiente'
    };

    state.citas = state.citas.map(function (day) {
      return day.day === state.diaSeleccionado
        ? { day: day.day, citas: day.citas.concat([nuevaCita]) }
        : day;
    });

    els.patientInput.val('');
    els.testInput.val('MCMI-IV');
    els.timeInput.val('');

    cerrarModal();
    render();
  }

  function eliminarCita(day, id) {
    state.citas = state.citas.map(function (item) {
      return item.day === day
        ? { day: item.day, citas: item.citas.filter(function (cita) { return cita.id !== id; }) }
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

          return $.extend({}, cita, { estado: siguienteEstado[cita.estado] });
        })
      };
    });

    render();
  }

  function closeMenus() {
    $('[id^="menu-"]').addClass('hidden');
  }

  /* ------------------------- Eventos ------------------------- */
  function bindEvents() {
    // Modal
    $('#openModal').on('click', abrirModal);
    $('#closeModal').on('click', cerrarModal);
    $('#saveAppointment').on('click', agregarCita);

    els.modalBackdrop.on('click', function (e) {
      if (e.target === this) {
        cerrarModal();
      }
    });

    // Navegación de meses
    $('#prevMonth, #prevMonthSide').on('click', function () { navegarMes(-1); });
    $('#nextMonth, #nextMonthSide').on('click', function () { navegarMes(1); });

    // Botones de mes (delegación, contenido dinámico)
    els.monthList.on('click', '[data-month]', function () {
      state.mesActivo = Number($(this).data('month'));
      render();
    });

    // Búsqueda
    $('#searchToggle').on('click', function () {
      var hidden = els.searchBar.hasClass('hidden');

      if (hidden) {
        els.searchBar.removeClass('hidden').addClass('flex');
        setTimeout(function () { els.searchInput.trigger('focus'); }, 0);
      } else {
        els.searchBar.addClass('hidden').removeClass('flex');
        state.busqueda = '';
        els.searchInput.val('');
        els.clearSearch.addClass('hidden');
        renderDays();
        hydrateIcons();
      }
    });

    els.searchInput.on('input', function () {
      state.busqueda = $(this).val();
      els.clearSearch.toggleClass('hidden', !state.busqueda);
      renderDays();
      hydrateIcons();
    });

    els.clearSearch.on('click', function () {
      state.busqueda = '';
      els.searchInput.val('');
      els.clearSearch.addClass('hidden');
      renderDays();
      hydrateIcons();
    });

    els.cancelSearch.on('click', function () {
      state.busqueda = '';
      els.searchInput.val('');
      els.clearSearch.addClass('hidden');
      els.searchBar.addClass('hidden').removeClass('flex');
      render();
    });

    // Días con citas: toggle de estado, menú, eliminar (delegación)
    els.daysList.on('click', '[data-action="toggle-status"]', function () {
      toggleEstado(Number($(this).data('day')), $(this).data('id'));
    });

    els.daysList.on('click', '[data-action="menu"]', function (e) {
      e.stopPropagation();
      closeMenus();
      $('#menu-' + $(this).data('id')).toggleClass('hidden');
    });

    els.daysList.on('click', '[data-action="delete"]', function () {
      eliminarCita(Number($(this).data('day')), $(this).data('id'));
    });

    // Mini calendario (delegación)
    els.miniCalendar.on('click', '[data-mini-day]', function () {
      state.diaSeleccionado = Number($(this).data('miniDay'));
      render();
    });

    // Días del formulario (delegación)
    els.dayButtons.on('click', '[data-form-day]', function () {
      state.diaSeleccionado = Number($(this).data('formDay'));
      renderFormDays();
    });

    // Cerrar menús flotantes con clic fuera / tecla Escape
    $(document).on('click', closeMenus);

    $(document).on('keydown', function (e) {
      if (e.key === 'Escape') {
        closeMenus();

        if (!els.modalBackdrop.hasClass('hidden')) {
          cerrarModal();
        }
      }
    });
  }

  /* ------------------------- Inicialización ------------------------- */
  els.testInput.html(pruebasLista.map(function (p) {
    return '<option value="' + escapeHtml(p) + '">' + escapeHtml(p) + '</option>';
  }).join(''));

  bindEvents();
  render();
})(jQuery);