<?php

#正常通信code码
const RESPONSE_SUCCESS_CODE                         = 0;
#1000 - 2000 通用错误码
const REQUEST_PARAMS_VALIDATE_ERROR_CODE            = 1000;
const REQUEST_PARAMS_VALIDATE_ERROR_MSG             = '参数验证失败';
const RESPONSE_API_EXCEPTION_CODE                   = 1001;
const RESPONSE_API_EXCEPTION_MSG                    = '接口异常';
const RESPONSE_SERVER_EXCEPTION_CODE                = 1002;
const RESPONSE_SERVER_EXCEPTION_MSG                 = '服务器异常';

#2001 错误码
const USER_PASSWORD_VALIDATE_ERROR_CODE             = 20001;
const USER_PASSWORD_VALIDATE_ERROR_MSG              = '用户密码错误';

const USER_ACCESS_TOKEN_VALIDATE_ERROR_CODE         = 20002;
const USER_ACCESS_TOKEN_VALIDATE_ERROR_MSG          = 'token已失效，请重新登陆';

const USER_CHAT_NO_NOT_UPDATE_ERROR_CODE            = 20003;
const USER_CHAT_NO_NOT_UPDATE_ERROR_MSG             = '微聊号不允许更新';

const FILE_UPLOAD_FAIL_CODE                         = 20004;
const FILE_UPLOAD_FAIL_MSG                          = '文件上传失败';

const NOT_ALLOW_UPLOAD_FILE_FORMAT_CODE             = 20005;
const NOT_ALLOW_UPLOAD_FILE_FORMAT_MSG              = '请上传正确的图片格式';

const NOT_FIND_CHAT_NO_CODE                         = 20006;
const NOT_FIND_CHAT_NO_MSG                          = '微聊号不存在';

const YOU_CAN_NOT_ADD_YOURSELF_AS_FRIEND_CODE       = 20007;
const YOU_CAN_NOT_ADD_YOURSELF_AS_FRIEND_MSG        = '您不能添加自己为好友';

const NOT_FIND_FRIEND_APPLY_CODE                    = 20008;
const NOT_FIND_FRIEND_APPLY_MSG                     = '没有找到此申请记录';

const FRIEND_NOT_EXIST_CODE                         = 20009;
const FRIEND_NOT_EXIST_MSG                          = '用户不存在';

const REFUSED_FRIEND_APPLY_CODE                     = 20010;
const REFUSED_FRIEND_APPLY_MSG                      = '已拒绝好友申请';

const FRIEND_NOT_EXIST_ON_CONTACT_CODE              = 20011;
const FRIEND_NOT_EXIST_ON_CONTACT_MSG               = '此好友不在您的通讯录中';

const FRIEND_REMARKS_SAVE_FAIL_CODE                 = 20012;
const FRIEND_REMARKS_SAVE_FAIL_MSG                  = '好友备注修改失败';

const SEND_CHAT_MESSAGE_FAIL_CODE                   = 20013;
const SEND_CHAT_MESSAGE_FAIL_MSG                    = '消息发送失败';

const NO_HAVE_MORE_MESSAGE_CODE                     = 20014;
const NO_HAVE_MORE_MESSAGE_MSG                      = '没有更多的消息了';

