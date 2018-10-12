import { HttpErrorResponse } from '@angular/common/http';

export class AppErrorHandler {
  readonly VALIDATION_ERROR = 422;

  private _message: string = '';
  private _status: number;

  constructor( error: HttpErrorResponse ) {
    this._status = error.status;

    if (this._status === this.VALIDATION_ERROR) {
      const message = error.error.validation_messages;

      Object.keys(message).forEach(field => {
        const messageList = (message[field] instanceof Array) ?
          message[field] :
          Object.keys(message[field]).map(key => message[field][key]);

        messageList.forEach(validateName =>
          this._message += '<li>' + validateName + '</li>'
        );
      });
    }
  }

  get result(): boolean {
    return false;
  }

  get status(): number {
    return this._status;
  }

  get message(): string {
    return this._message;
  }
}
