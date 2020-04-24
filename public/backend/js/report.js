function Transactions(options) {
      var _ = this;
      _.options = options;
      _.datatable = null;
      _.datatableOptions = null;

      _.prepareOptions = function (data, dates) {
          dates = dates || {};
          return {
              pageLength: 20,
              processing: true,
              serverSide: true,
              ajax: {
                  url: data.url,
                  data: dates
              },
              order: [[0, 'desc']],
              columns: data.cols,
              columnDefs: (data.columnDefs != undefined) ? data.columnDefs : []
          }
      }

      // _.prepareExportUrl = function (dates) {
      //     if (dates) {
      //         return data.exportUrl + '?start_date=' + dates.start_date + '&end_date=' + dates.end_date;
      //     }
      //     return data.exportUrl;
      // }

      _.datatableInit = function (data) {
          _.datatable = $(data.selector).DataTable(_.prepareOptions(data));
      }

      _.dateRangeInit = function () {
          $(_.options.dateRangeSelector).daterangepicker({
              autoUpdateInput: false,
              locale: {
                  applyLabel: 'Применять',
                  cancelLabel: 'Очистить'
              }
          });

          $(_.options.dateRangeSelector).on('apply.daterangepicker', function (ev, picker) {
              $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
              $(_.options.orders.selector).dataTable().fnDestroy();
              $(_.options.expenses.selector).dataTable().fnDestroy();
              var dates = {
                  start_date: picker.startDate.format('DD-MM-YYYY'),
                  end_date: picker.endDate.format('DD-MM-YYYY')
              };
              $(_.options.orders.selector).DataTable(_.prepareOptions(_.options.orders, dates));
              $(_.options.expenses.selector).DataTable(_.prepareOptions(_.options.expenses, dates));
              // $(_.options.exportBtnSelector).attr('href', _.prepareExportUrl(dates));

          });

          $(_.options.dateRangeSelector).on('cancel.daterangepicker', function (ev, picker) {
              $(this).val('');
          });
      }

      _.init = function () {
          _.datatableInit(_.options.orders);
          _.datatableInit(_.options.expenses);
          _.dateRangeInit();
          // $(_.options.exportBtnSelector).attr('href', _.prepareExportUrl());
      }

      _.init();
  }