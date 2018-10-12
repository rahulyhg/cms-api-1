import { FormControl, NG_VALIDATORS, Validator, ValidatorFn } from '@angular/forms';
import { Directive } from '@angular/core';

@Directive({
  selector: '[appEmailValidator][ngModel]',
  providers: [
    {
      provide: NG_VALIDATORS,
      useExisting: EmailValidator,
      multi: true
    }
  ]
})
export class EmailValidator implements Validator {
  validator: ValidatorFn;

  constructor() {
    this.validator = this.emailValidator();
  }

  validate( c: FormControl ) {
    return this.validator(c);
  }

  emailValidator(): ValidatorFn {
    return ( c: FormControl ) => {
      const isValid = /^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/.test(c.value);

      if (isValid) {
        return null;
      } else {
        return {
          emailvalidator: {
            valid: false
          }
        };
      }
    };
  }
}
