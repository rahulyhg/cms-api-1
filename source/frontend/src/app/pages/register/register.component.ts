import { Component, OnInit } from '@angular/core';
import { UserCredentialType } from '../../types/user.credential.type';
import { User } from '../../models/users.model';
import { AppErrorHandler } from '../../services/error-handler';
import { RpcResponseType } from '../../types/rpc.response.type';
import { AuthenticationService } from '../../services/authentication.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {
  errorMessage: string = '';
  isError: boolean = false;
  isLoading: boolean = false;
  user = new User();

  constructor(
    private userAuth: AuthenticationService,
    private router: Router
  ) {
  }

  ngOnInit() {
  }

  register( event ) {
    event.preventDefault();
    if (this.isLoading) {
      return false;
    }
    this.isLoading = true;

    this.userAuth.register(this.user)
      .subscribe(
        ( res: AppErrorHandler|RpcResponseType ) => {
          this.isLoading = false;
          if (res.result === false) {
            this.isError = true;
            this.errorMessage = res.message;
          } else {
            this.router.navigate([ 'login' ]);
          }
        }
      );}

  closeAlertMessage( event ) {
    this.isError = false;
  }
}
