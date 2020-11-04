<?php
$apiMappings = [
  0 => [
    "api_name" => "v1_getRequestOrder",
    "path" => "v1/requestOrder/{merchantPaymentId}",
    "method" => "GET",
  ],
  1 => [
    "api_name" => "v2_getWalletBalance",
    "path" => "",
    "method" => "GET",
  ],
  2 => [
    "api_name" => "v3_getWalletBalance",
    "path" => "v3/wallet/balance",
    "method" => "GET",
  ],
  3 => [
    "api_name" => "v2_fetchUserProfileForWebApp",
    "path" => "v2/user/authorizations/details",
    "method" => "GET",
  ],
  4 => [
    "api_name" => "v2_getPaymentMethods",
    "path" => "v2/paymentMethods",
    "method" => "GET",
  ],
  5 => [
    "api_name" => "v5_getWalletBalance",
    "path" => "v5/wallet/balance",
    "method" => "GET",
  ],
  6 => [
    "api_name" => "v2_getQRPaymentDetails",
    "path" => "v2/codes/payments/{merchantPaymentId}",
    "method" => "GET",
  ],
  7 => [
    "api_name" => "v2_getReversedCashBackDetails",
    "path" => "v2/cashback_reversal/{merchantCashbackReversalId}/{merchantCashbackID}",
    "method" => "GET",
  ],
  8 => [
    "api_name" => "v4_getWalletBalance",
    "path" => "v4/wallet/balance",
    "method" => "GET",
  ],
  9 => [
    "api_name" => "v2_getRefundDetails",
    "path" => "v2/refunds/{merchantRefundId}",
    "method" => "GET",
  ],
  10 => [
    "api_name" => "v6_getWalletBalance",
    "path" => "v6/wallet/balance",
    "method" => "GET",
  ],
  11 => [
    "api_name" => "v2_getTopUpDetails",
    "path" => "v2/wallet/topups/{merchantTopUpId}",
    "method" => "GET",
  ],
  12 => [
    "api_name" => "v2_getPaymentDetail",
    "path" => "v2/payments/{merchantPaymentId}",
    "method" => "GET",
  ],
  13 => [
    "api_name" => "v2_checkWalletBalance",
    "path" => "v2/wallet/check_balance",
    "method" => "GET",
  ],
  14 => [
    "api_name" => "v2_getCashbackDetails",
    "path" => "v2/cashback/{merchantCashbackId}",
    "method" => "GET",
  ],
  15 => [
    "api_name" => "v2_getUserProfile",
    "path" => "v2/user/profile",
    "method" => "GET",
  ],
  16 => [
    "api_name" => "v2_getSecureUserProfile",
    "path" => "v2/user/profile/secure",
    "method" => "GET",
  ],
  17 => [
    "api_name" => "v1_sendPushNotification",
    "path" => "v1/push/user/notification",
    "method" => "POST",
  ],
  18 => [
    "api_name" => "v1_createRequestOrder",
    "path" => "v1/requestOrder",
    "method" => "POST",
  ],
  19 => [
    "api_name" => "v1_createRequestOrderRefund",
    "path" => "v1/requestOrder/refunds",
    "method" => "POST",
  ],
  20 => [
    "api_name" => "v2_createUserAuthForWebApp",
    "path" => "v2/user/authorizations/applications",
    "method" => "POST",
  ],
  21 => [
    "api_name" => "v1_sendPushTemplateNotification",
    "path" => "v1/push/notification",
    "method" => "POST",
  ],
  22 => [
    "api_name" => "v2_captureAuthorizedOrder",
    "path" => "v2/payments/capture",
    "method" => "POST",
  ],
  23 => [
    "api_name" => "v2_revertAuthorizedOrder",
    "path" => "v2/payments/preauthorize/revert",
    "method" => "POST",
  ],
  24 => [
    "api_name" => "v2_createOrderAndAuthorize",
    "path" => "v2/payments/preauthorize",
    "method" => "POST",
  ],
  25 => [
    "api_name" => "v2_createUserWalletTopUp",
    "path" => "v2/user/wallet/topups",
    "method" => "POST",
  ],
  26 => [
    "api_name" => "v1_createSubscriptionPayment",
    "path" => "v1/subscription/payments",
    "method" => "POST",
  ],
  27 => [
    "api_name" => "v2_createCashBackRequest",
    "path" => "v2/cashback",
    "method" => "POST",
  ],
  28 => [
    "api_name" => "v2_createPayment",
    "path" => "v2/payments",
    "method" => "POST",
  ],
  29 => [
    "api_name" => "v2_createTopUp",
    "path" => "v2/wallet/topups",
    "method" => "POST",
  ],
  30 => [
    "api_name" => "v2_createDynamicQRCode",
    "path" => "v2/codes",
    "method" => "POST",
  ],
  31 => [
    "api_name" => "v2_createRefundPayment",
    "path" => "v2/refunds",
    "method" => "POST",
  ],
  32 => [
    "api_name" => "v2_createReverseCashBackRequest",
    "path" => "v2/cashback_reversal",
    "method" => "POST",
  ],
  33 => [
    "api_name" => "v1_sendPushTemplateNotificationToMerchantUser",
    "path" => "v1/push/merchant/users/notifications",
    "method" => "POST",
  ],
  34 => [
    "api_name" => "v1_cancelRequestOrder",
    "path" => "v1/requestOrder/{merchantPaymentId}",
    "method" => "DELETE",
  ],
  35 => [
    "api_name" => "v2_deleteDynamicQRCode",
    "path" => "v2/codes/{code}",
    "method" => "DELETE",
  ],
  36 => [
    "api_name" => "v2_cancelPayment",
    "path" => "v2/payments/{merchantPaymentId}",
    "method" => "DELETE",
  ],
];