var Ticket = {
    form: $('.js-send-message'),
    btn: $('.js-send-btn'),
    msgContainer: $('.msg_container_base'),

    renderMessage: function(msg)
    {
        return '<div class="row msg_container base_sent">'
        + '<div class="col-md-10 col-xs-10">'
          + '<div class="messages msg_sent">'
            + '<b>' + msg.user.name + '</b>'
              + '<p>' + msg.message + '</p>'
                + '<time datetime="">now</time>'
            + '</div>'
          + '</div>'
        + '</div>';
    },

    onSend: function()
    {
        this.form.on('submit', function(e) {
            var _this = $(this)
            e.preventDefault()
            Ticket.btn.prop('disabled', true)
            Ticket.btn.prepend('<i class="fa fa-spinner fa-spin"></i> ');
            $.ajax({
                method: 'POST',
                url   : _this.attr('action'),
                data  : _this.serialize(),

                success : function(data) {
                    Ticket.msgContainer.append(Ticket.renderMessage(data.message));
                    Ticket.btn.prop('disabled', false)
                    Ticket.btn.find('i').remove();
                    Ticket.form.find('input[name=message]').val('')
                    Ticket.msgContainer.scrollTop(Ticket.msgContainer[0].scrollHeight)
                }
            })
        })
    },

    init: function()
    {
        this.msgContainer.scrollTop(this.msgContainer[0].scrollHeight)
        this.onSend();
    }
}