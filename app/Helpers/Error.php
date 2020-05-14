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

const FILE_UPLOAD_FAIL_CODE                         = 20003;
const FILE_UPLOAD_FAIL_MSG                          = '文件上传失败';

const NOT_ALLOW_UPLOAD_FILE_FORMAT_CODE             = 20005;
const NOT_ALLOW_UPLOAD_FILE_FORMAT_MSG              = '请上传正确的图片格式';
