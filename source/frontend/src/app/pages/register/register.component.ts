import { Component, OnInit } from '@angular/core';
import { User } from '../../models/users.model';
import { RpcResponseType } from '../../types/rpc-response.type';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';
import { UserService } from '../../services/user.service';
import { AbstractControl, FormBuilder, FormGroup, ValidatorFn, Validators } from '@angular/forms';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: [ './register.component.scss' ]
})
export class RegisterComponent implements OnInit {
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
      email: [ '', [ Validators.required, Validators.email ] ],
      fullName: [ '', [ Validators.required, Validators.minLength(5) ] ],
      password: [ '', [ Validators.required, Validators.minLength(6), Validators.maxLength(16) ] ],
      confirmPassword: [ '', [ this.match('password') ] ],
    });
  }

  private match( withField: string ): ValidatorFn {
    return ( currentControl: AbstractControl ): { [key: string]: any } => {
      if (currentControl.parent instanceof FormGroup) {
        if (currentControl.value === '' || currentControl.value !== currentControl.parent.get(withField).value) {
          return { 'match': true };
        }
        return null;
      }
    }
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
          if (res.success === false) {
            console.log(res);
          } else {
            console.log("Registered");
            // localStorage.setItem('registeredUser', res.message);
            // this.router.navigate([ 'login' ]);
          }
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
