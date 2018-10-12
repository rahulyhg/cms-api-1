import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { catchError } from 'rxjs/internal/operators';
import { Observable, of } from 'rxjs/index';
import { AppErrorHandler } from './error-handler';

@Injectable()
export class AuthenticationService {
  readonly baseUrl: string = 'http://localhost:8080/';

  constructor( private http: HttpClient ) {
  }

  login( email: string, password: string ) {
    const body = {
      email: email,
      password: password
    };
    return this.http.post<any>(this.baseUrl + 'api/login', body)
      .pipe(
        catchError(this.handleError('login'))
      );
  }

  private handleError( operation = 'operation', resutl?: AppErrorHandler) {
    return ( error: HttpErrorResponse ): Observable<AppErrorHandler> => {
      const errMessage = new AppErrorHandler(error);
      return of(errMessage as AppErrorHandler);
    };
  }

  logout() {
  }
}
