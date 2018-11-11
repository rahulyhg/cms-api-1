import { Injectable } from '@angular/core';
import { HttpRequest, HttpHandler, HttpEvent, HttpInterceptor } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { AuthService } from '../services/auth.service';
import { catchError } from 'rxjs/internal/operators';

@Injectable()
export class UnauthorizedInterceptor implements HttpInterceptor {
  constructor(
    private authService: AuthService
  ) {
  }

  intercept( request: HttpRequest<any>, next: HttpHandler ): Observable<HttpEvent<any>> {

    return next.handle(request)
      .pipe(
        catchError(err => {
            if (err.status === 401 || err.status === 403) {
              this.authService.logout();
              location.reload(true);
            }

            const error = err.error.message || err.statusText;
            return throwError(error);
          }
        )
      );
  }
}
