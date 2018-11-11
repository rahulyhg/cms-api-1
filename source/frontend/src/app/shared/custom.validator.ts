import { AbstractControl, FormGroup, ValidatorFn } from '@angular/forms';

export class CustomValidator {

  /**
   * Match value with another ActiveForm field
   */
  static match( withField: string ): ValidatorFn {
    return (
      currentControl: AbstractControl
    ): { [key: string]: any } => {
      if (currentControl.parent instanceof FormGroup) {
        if (currentControl.value === '' || currentControl.value !== currentControl.parent.get(withField).value) {
          return { 'match': true };
        }
        return null;
      }
    };
  }

  /**
   * Validate email
   */
  static email(): ValidatorFn {
    return (
      currentControl: AbstractControl
    ): { [key: string]: any } => {
      const pattern = /^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

      if (!pattern.test(currentControl.value)) {
        return { 'email': true };
      }
      return null;
    };
  }
}
