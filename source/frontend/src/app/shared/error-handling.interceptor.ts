import { Injectable } from '@angular/core';
import { HttpRequest, HttpHandler, HttpEvent, HttpInterceptor, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { AuthService } from '../services/auth.service';
import { catchError } from 'rxjs/internal/operators';

@Injectable()
export class ErrorHandlingInterceptor implements HttpInterceptor {
  constructor(
    private authService: AuthService
  ) {
  }

  intercept( request: HttpRequest<any>, next: HttpHandler ): Observable<HttpEvent<any>> {

    return next.handle(request)
      .pipe(
        catchError((err: HttpErrorResponse) => {
            switch ( err.status ) {
              case 401:
              case 403:
                this.authService.logout();
                location.reload(true);
                break;
              case 422:
                return throwError(err.error);
                break;
            }

            const error = err.error.message || err.statusText;
            return throwError(error);
          }
        )
      );
  }
}
