import { toNumber } from "./toNumber";

export function formatTime(seconds: number, guide: number) {
  seconds = seconds < 0 ? 0 : seconds;
  let s: string | number = Math.floor(seconds % 60);
  let m: string | number = Math.floor((seconds / 60) % 60);
  let h: string | number = Math.floor(seconds / 3600);
  const gm = Math.floor((guide / 60) % 60);
  const gh = Math.floor(guide / 3600);

  // handle invalid times
  if (isNaN(seconds) || seconds === Infinity) {
    // '-' is false for all relational operators (e.g. <, >=) so this setting
    // will add the minimum number of fields specified by the guide
    h = m = s = "-";
  }

  // Check if we need to show hours
  h = toNumber(h) > 0 || gh > 0 ? h + ":" : "";

  // If hours are showing, we may need to add a leading zero.
  // Always show at least one digit of minutes.
  m = ((h || gm >= 10) && toNumber(m) < 10 ? "0" + m : m) + ":";

  // Check if leading zero is need for seconds
  s = toNumber(s) < 10 ? "0" + s : s;

  return h + m + s;
}
