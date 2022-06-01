1.13.2, 2020-05-20:
- [embedded] Manage new metadata field format returned in REST API IPN.
- Bug fix: Fix sent data according to new Transaction/Update REST WS.
- Send PrestaShop username and IP as a comment on refund WS calls.
- Improve some plugin translations.
- Improve redirection to gateway page.

1.13.1, 2020-04-07:
- Restore compatibility with PHP v5.3.
- [embedded] Bugfix: Payment fields error relative to new JavaScript client library.

1.13.0, 2020-03-04:
- Bug fix: Fix amount issue relative to multiple partial refunds.
- Bug fix: Shipping costs not included in the refunded amount through the PrestaShop backend.
- [oney] Adding 3x 4x Oney means of payment as submodule.
- Improve payment statuses management.

1.12.1, 2020-02-04:
- [alias] Bug fix: card data was requested even if the buyer chose to use his registered means of payment.

1.12.0, 2020-01-30:
- Bug fix: 3DS result is not correctly saved in backend order details when using embedded payment fields.
- Bug fix: Fix theme config setting for iframe mode.
- [embedded] Added possibility to display REST API fields in pop-in mode.
- Possibility to make refunds for payments.
- Possibility to cancel payment in iframe mode.
- [alias] Added payment by token.
- [sepa] Save SEPA aliases separately from CB payment aliases.
- [sepa] Added possibility to configure SEPA submodule payment.
- [technical] Do not use vads\_order\_info2 gateway parameter.
- [oney] Added warning when delivery methods are updated.
- Removed feature data acquisition on merchant website.
- Possibility to not send shopping cart content when not mandatory.
- Restrict payment submodules to specific countries.

1.11.4, 2019-11-28:
- Bug fix: duplicate entry error on table ps\_message\_readed at the end of the payment.

1.11.3, 2019-11-12:
- Bug fix: currency and effective currency fields are inverted in REST API response.
- Bug fix: redirection form loaded from cache in some cases in iframe mode.
- Bug fix: URL error in iframe mode relative to slash at end of base URL.