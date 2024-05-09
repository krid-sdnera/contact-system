export class AppError {
  code: ErrorCode;
  message: string;
  previous: Error | undefined;
  constructor(code: ErrorCode, message: string, previous?: Error | undefined) {
    this.code = code;
    this.message = message;
    this.previous = previous;
  }
}

export enum ErrorCode {
  InternalError = 'InternalError',
  AuthRefreshTokenInvalid = 'AuthRefreshTokenInvalid',
  EntityNotFound = 'EntityNotFound',
}
