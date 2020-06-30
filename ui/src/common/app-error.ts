export class AppError {
  code: ErrorCode;
  message: string;
  constructor(code: ErrorCode, message: string) {
    this.code = code;
    this.message = message;
  }
}

export enum ErrorCode {
  InternalError = 'InternalError',
}
