import { Component, OnInit } from '@angular/core';
import { RpcResponseType } from '../../types/rpc-response.type';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';
import { UserService } from '../../services/user.service';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { CustomValidator } from '../../shared/custom.validator';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: [ './register.component.scss' ]
})
export class RegisterComponent implements OnInit {
  errorMessages = [];
  isLoading = false;
  form: FormGroup;

  constructor(
    private fb: FormBuilder,
    private userService: UserService,
    private authService: AuthService,
    private router: Router
  ) {
    if (this.authService.identity) {
      this.router.navigate([ 'dashboard' ]);
    }
  }

  ngOnInit() {
    this.form = this.fb.group({
      email: [ '', [ Validators.required, CustomValidator.email() ] ],
      fullName: [ '', [ Validators.required, Validators.minLength(5) ] ],
      password: [ '', [ Validators.required, Validators.minLength(6), Validators.maxLength(16) ] ],
      confirmPassword: [ '', [ CustomValidator.match('password') ] ],
    });
  }

  public register(): void {
    if (this.form.invalid || this.isLoading) {
      return;
    }
    this.isLoading = true;

    this.userService
      .register(this.form.value)
      .subscribe(
        ( res: RpcResponseType ) => {
          this.isLoading = false;
          this.router.navigate([ 'login' ]);
        },
        error => {
          this.isLoading = false;
          this.errorMessages = error.validation_messages.email;
        }
      );
  }

  get f() {
    return this.form.controls;
  }

  public fieldClassValidation( fieldName: any ): { valid: boolean, invalid: boolean } {
    const isEdited = this.form.get(fieldName).dirty || this.form.get(fieldName).touched;
    return {
      valid: isEdited && this.form.get(fieldName).valid,
      invalid: isEdited && this.form.get(fieldName).invalid
    };
  }
}
